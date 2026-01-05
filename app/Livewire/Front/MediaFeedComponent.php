<?php

namespace App\Livewire\Front;

use App\Models\MediaPost;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Follow;
use App\Models\Report;
use App\Models\ReportResion;
use App\Models\SafariDiscussion;

#[Layout('components.layouts.guest')]
class MediaFeedComponent extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $newComment = [];
    public $showComments = [];
    public $loadingMore = false, $showLikeModel = false, $PostLikesLists = [], $hasMoreLikes = true, $postId = null;
    public $likesPerPage = 5;
    public $reportDiscussionId;
    public $selectedResion;
    public $notes;
    public $reportResions = [];
    public $showReportModal = false;


    public function likePost($postId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $post = MediaPost::find($postId);
        if (!$post) return;

        $userId = Auth::guard('web')->user()->id;

        if ($post->likes()->where('user_id', $userId)->exists()) {
            $post->likes()->where('user_id', $userId)->delete();
        } else {
            $post->likes()->create(['user_id' => $userId]);
        }
    }

    public function addComment($postId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            "newComment.$postId" => 'required|string|max:300',
        ], [
            "newComment.$postId.required" => 'Please write a comment before sending.',
            "newComment.$postId.string" => 'Comment must be valid text.',
            "newComment.$postId.max" => 'Comment cannot exceed 300 characters.',
        ]);

        PostComment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'comment' => $this->newComment[$postId],
        ]);

        $this->newComment[$postId] = '';
    }

    public function loadMore()
    {
        $this->perPage += 5;
        $this->loadingMore = true;
    }

    public function render()
    {
        $posts = MediaPost::with(['user', 'likes', 'comments.user'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
        // dd($posts);
        return view('livewire.front.midia-feed-component', [
            'posts' => $posts
        ]);
    }



    public function toggleFollow($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $followerId = Auth::id();

        if ($followerId == $userId) {
            return;
        }

        $follow = Follow::where('follower_id', $followerId)
            ->where('following_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete();
        } else {
            Follow::create([
                'follower_id' => $followerId,
                'following_id' => $userId,
                'status' => 'accepted',
            ]);
        }
    }

    public function isFollowing($userId)
    {
        if (!Auth::check()) return false;

        return Follow::where('follower_id', Auth::id())
            ->where('following_id', $userId)
            ->exists();
    }

    public function showlikesModalData($postId)
    {
        $this->showLikeModel = true;
        $this->postId = $postId;
        $this->loadLikes();
    }

    public function loadLikes()
    {
        $likes = MediaPost::find($this->postId)
            ->likes()
            ->with(['user' => function ($query) {
                $query->select('user_id', 'username', 'name', 'profile_photo_path');
            }])
            ->take($this->likesPerPage)
            ->get();

        $this->PostLikesLists = $likes;

        $post = MediaPost::find($this->postId);

        $likesCount = $post->likes()->count();

        $this->hasMoreLikes = $likesCount > $this->likesPerPage;


        // $this->hasMoreLikes = MediaPost::find($this->postId)
        //     ->likes()
        //     ->skip($this->likesPerPage)
        //     ->exists();

    }

    public function loadMoreLikes()
    {

        $this->likesPerPage += 5;
        $this->loadLikes();
    }

    public function openReportModal($discussionId)
    {
        $this->reportDiscussionId = $discussionId;
        $this->reportResions = ReportResion::where('status', '1')->get();
        $this->selectedResion = null;
        $this->notes = '';
        $this->showReportModal = true;
    }

    public function submitReport()
    {
        $this->validate([
            'selectedResion' => 'required|exists:report_resions,report_resion_id',
            'notes' => 'nullable|string|max:500',
        ]);
        $discussion =  SafariDiscussion::where('safari_discussion_id', $this->reportDiscussionId)->first();
        Report::create([
            'user_id' => Auth::id(),
            'report_type' => 'post',
            'post_id' =>  $this->reportDiscussionId,
            'report_resion_id' => $this->selectedResion,
            'details' => $this->notes,
        ]);

        $this->reset(['showReportModal', 'selectedResion', 'notes', 'reportDiscussionId']);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Report submitted successfully!',
        ]);
    }
}
