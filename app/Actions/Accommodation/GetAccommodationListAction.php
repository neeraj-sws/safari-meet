<?php

namespace App\Actions\Accommodation;

use App\Models\EnquiryAccommodation;
use Illuminate\Support\Collection;

class GetAccommodationListAction
{
    public function execute(): Collection
    {
        return EnquiryAccommodation::query()
            ->select('id', 'title')
            ->where('status', 1)
            ->orderBy('title')
            ->get();
    }
}
