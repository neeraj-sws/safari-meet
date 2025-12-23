<?php

namespace App\Livewire\Admin\Package\Details;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\PackageBanner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class BannerImages extends Component
{
    use WithFileUploads;

    public $pageTitle = "Key Info";
    public $characterDetails, $package, $activeTabe, $isEditing = false;
    public $banner_images = [], $bannerpreviousImage;


    public function mount($package = null, $characterstic = null)
    {
        $this->package = $package;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'images';
    }

    public function render()
    {
        $bannerImages = PackageBanner::where('package_id', $this->package->id)->latest()->get();
        return view('livewire.admin.package.details.banner-images', compact('bannerImages'));
    }

    public function store()
    {
        set_time_limit(300);
        if (!empty($this->package)) {

            if ($this->banner_images) {
                foreach ($this->banner_images as $image) {
                    try {
                        // $origPath = $image->store('uploads/safari/package/banner', 'public_root');
                        // $imagePath = ImageHelper::convertToAvif($origPath, 'uploads/safari/package/banner');
                        $imagePath =  ImageUploadHelper::upload($image, 'uploads/safari/package/banner');
                        PackageBanner::create([
                            'package_id' => $this->package->id,
                            'image' => $imagePath,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Image conversion failed: ' . $e->getMessage());
                    }
                }
                $this->reset(['banner_images']);
                $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
                return;
            } else {
                return $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => " Upload Banner Image is required"]);
            }
        } else {
            return $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => "Somthing Went's Wrong"]);
        }
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->reset(['banner_images']);
    }

    public function removeBannerImage($index)
    {
        unset($this->banner_images[$index]);
        $this->banner_images = array_values($this->banner_images);
    }

    public function deleteBannerImage($id)
    {
        $bannerImages = PackageBanner::find($id);
        // if (!empty($bannerImages) && file_exists(public_path($bannerImages->image))) {
        //     @unlink(public_path($bannerImages->image));
        // }
         ImageUploadHelper::delete($bannerImages->image);
        $bannerImages->delete();
    }
}
