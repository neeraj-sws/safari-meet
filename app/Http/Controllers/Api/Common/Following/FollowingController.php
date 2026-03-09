<?php

namespace App\Http\Controllers\Api\Common\Following;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Api\BaseController;
use App\Models\Follow;
use App\Models\MediaPost;
use App\Models\PostComment;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FollowingController extends BaseController
{
    public function addFollowing(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'following_id' => 'required|integer|exists:users,user_id|not_in:' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
                'status' => 400,
            ], 400);
        }

        $validated = $validator->validated();

        $existingFollow = Follow::where('follower_id', $user->id)
            ->where('following_id', $validated['following_id'])
            ->first();

        if ($existingFollow) {
            return response()->json([
                'message' => 'You are already following this user.',
                'data' => [],
                'status' => 400,
            ], 400);
        }

        $follow =  Follow::create([
            'follower_id' => $user->id,
            'following_id' => $validated['following_id'],
            'status' => 'accepted',
        ]);

        $follow->load(['follower', 'following']);
        return response()->json([
            'message' => 'Follow request accepted.',
            'data' => $follow,
            'status' => 200,
        ], 200);
    }

    public function FollowerFollowingList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
                'status' => 400,
            ], 400);
        }

        $userId = $request->input('user_id');

        $followers = Follow::where('following_id', $userId)
            ->where('status', 'accepted')
            ->where('follower_id', '!=', $userId)
            ->with(['follower:id,name,image'])
            ->get()
            ->pluck('follower');


        $following = Follow::where('follower_id', $userId)
            ->where('status', 'accepted')
            ->where('following_id', '!=', $userId)
            ->with(['following:id,name,profile_photo_path'])
            ->get()
            ->pluck('following');

        return response()->json([
            'success' => true,
            'data' => [
                'followers' => $followers,
                'following' => $following,
            ],
        ]);
    }


    public function storeImagePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caption' => 'nullable|string|max:1000',
            'type_of_media' => 'required|in:image,video',
        ]);

        if ($request->type_of_media == 'image') {
            $validator->addRules([
                'image' => 'required|mimes:jpg,jpeg,png,webp|max:10240',
            ]);
        } elseif ($request->type_of_media == 'video') {
            $validator->addRules([
                'video' => 'required|mimes:mp4,mov,avi,mkv,flv,webm|max:51200',
            ]);
        }


        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }
        $path = 'uploads/social/posts';
        $mediaPath = '';

        if ($request->type_of_media === 'image') {
            $imagePath = $request->image->store("$path/images", 'public_root');
            $mediaPath = ImageHelper::convertToAvif($imagePath, "$path/images");
        } elseif ($request->type_of_media === 'video') {
            $mediaPath = $request->video->store("$path/videos", 'public_root');
        }

        $post = MediaPost::create([
            'user_id' => $request->user()->id,
            'user_type' => 'user',
            'media_url' => $mediaPath,
            'caption' => $request->caption,
            'type' => $request->type_of_media,
            'visibility' => 'public',
        ]);

        $fullImageUrl = asset($imagePath);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => [
                'user_id' => $post->user_id,
                'media_url' => $fullImageUrl,
                'caption' => $post->caption,
                'type' => $post->type,
                'visibility' => $post->visibility,
                'updated_at' => $post->updated_at,
                'created_at' => $post->created_at,
                'id' => $post->id
            ],
            'status' => 200,
        ], 200);
    }

    public function toggleLike(Request $request, $postId)
    {
        $user = $request->user();

        $existingLike = PostLike::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'message' => 'Like removed successfully',
                'status' => 'unliked',
            ]);
        }

        PostLike::create([
            'post_id' => $postId,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Post liked successfully',
            'status' => 'liked',
            'status' => 200,
        ]);
    }


    public function addComment(Request $request, $postId)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $comment = PostComment::create([
            'post_id' => $postId,
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'data' => [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at,
            ],
            'status' => 200,

        ]);
    }

    public function getComment(Request $request)
    {
        if (!$request->post_id) {
            return response()->json(['message' => 'Post not Found'], 400);
        }
        $post_comment = PostComment::with('user:id,name')
            ->where('post_id', $request->post_id)
            ->select('id', 'comment', 'user_id')->get();
        return response()->json([
            'message' => 'Comment fetched successfully',
            'data' => $post_comment,
            'status' => true,

        ], 200);
    }

    public function getRecentPosts(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $post_type = $request->get('post_type', 'image');
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => true,
                'message' => 'user is not login',
                'data' => [],
            ], 400);
        }
        $userId = $user->id;

        $posts = MediaPost::with(['user:user_id,name,profile_photo_path'])
            ->withCount(['likes', 'comments'])
            ->where('type',$post_type)
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'page', $page);

        $now = now();

        $formatted = $posts->getCollection()->transform(function ($post) use ($now, $userId) {

            $isLiked = $post->likes()->where('user_id', $userId)->exists();
            $isfollow =  Follow::where('follower_id', $userId)->where('following_id', $post->user_id)->where('status', 'accepted')->exists();

            $diffInHours = $now->diffInHours($post->created_at);
            $diffInDays = $now->diffInDays($post->created_at);
            $timeAgo = $diffInHours < 24
                ? $post->created_at->diffForHumans()
                : "{$diffInDays} day" . ($diffInDays > 1 ? 's' : '') . ' ago';

            return [
                'post_id' => $post->id,
                'caption' => $post->caption,
                'media_url' => url($post->media_url),
                'user' => [
                    'name' => $post->user->name ?? 'Unknown',
                    'profile_photo' => url($post->user->profile_photo_path ?? ''),
                ],
                'likes_count' => $post->likes_count,
                'comments_count' => $post->comments_count,
                'created_at' => $post->created_at->toDateTimeString(),
                'time_ago' => $timeAgo,
                'is_like' => $isLiked ? 1 : 0,
                'is_follow' => $isfollow ? 1 : 0,
            ];
        });

        $pagination = [
            'current_page' => $posts->currentPage(),
            'per_page'     => $posts->perPage(),
            'last_page'    => $posts->lastPage(),
            'total'        => $posts->total(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Recent posts fetched successfully',
            'data' => $formatted,
            'pagination' => $pagination,
        ], 200);
    }



    public function getPostComments(Request $request)
    {
        $postId = $request->get('post_id');
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);

        if (!$postId) {
            return response()->json([
                'status' => 400,
                'message' => 'Post ID is required.',
                'data' => null,
            ], 200);
        }

        $comments = PostComment::with('user')
            ->where('post_id', $postId)
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'page', $page);

        $now = now();

        $formattedComments = $comments->getCollection()->map(function ($comment) use ($now) {
            $createdAt = $comment->created_at;
            $diffInHours = $now->diffInHours($createdAt);

            $commentTimeAgo = $diffInHours < 24
                ? $createdAt->diffForHumans()
                : $now->diffInDays($createdAt) . ' day' . ($now->diffInDays($createdAt) > 1 ? 's' : '') . ' ago';

            return [
                'id' => $comment->id,
                'user_name' => $comment->user->name ?? 'Unknown',
                'comment' => $comment->comment,
                'created_at' => $createdAt->format('d M Y, h:i A'),
                'time_ago' => $commentTimeAgo,
            ];
        });

        $pagination = [
            'current_page' => $comments->currentPage(),
            'per_page'     => $comments->perPage(),
            'last_page'    => $comments->lastPage(),
            'total'        => $comments->total(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Comments fetched successfully.',
            'data' => $formattedComments,
            'pagination' => $pagination,
        ], 200);
    }

    public function getPostLikes(Request $request)
    {
        $postId = $request->get('post_id');
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);

        if (!$postId) {
            return response()->json([
                'status' => 400,
                'message' => 'Post ID is required.',
                'data' => null,
            ], 200);
        }

        $likes = PostLike::with('user:user_id,name,profile_photo_path')
            ->where('post_id', $postId)
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'page', $page);

        $now = now();

        $formattedLikes = $likes->getCollection()->map(function ($like) use ($now) {
            $createdAt = $like->created_at;
            $diffInHours = $now->diffInHours($createdAt);

            $likeTimeAgo = $diffInHours < 24
                ? $createdAt->diffForHumans()
                : $now->diffInDays($createdAt) . ' day' . ($now->diffInDays($createdAt) > 1 ? 's' : '') . ' ago';

            return [
                'id' => $like->id,
                'user_name' => $like->user->name ?? 'Unknown',
                'profile_photo' => url($post->user->profile_photo_path ?? ''),
                'created_at' => $createdAt->format('d M Y, h:i A'),
                'time_ago' => $likeTimeAgo,
            ];
        });

        $pagination = [
            'current_page' => $likes->currentPage(),
            'per_page'     => $likes->perPage(),
            'last_page'    => $likes->lastPage(),
            'total'        => $likes->total(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Like fetched successfully.',
            'data' => $formattedLikes,
            'pagination' => $pagination,
        ], 200);
    }
}
