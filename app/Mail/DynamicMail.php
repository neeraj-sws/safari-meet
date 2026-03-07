<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DynamicMail extends Mailable 
{
   

    public string $subjectLine;
    public string $bodyHtml;
    public ?string $attachmentPath;

    public function __construct(string $subjectLine, string $bodyHtml, string $attachmentPath = null)
    {
        $this->subjectLine = $subjectLine;
        $this->bodyHtml = $bodyHtml;
        $this->attachmentPath = $attachmentPath;
    }

    public function build()
    {
        $mail = $this->subject($this->subjectLine)
            ->html($this->bodyHtml);

        if ($this->attachmentPath) {

            if (str_starts_with($this->attachmentPath, 'http')) {

                $disk = Storage::disk('s3');
                $baseUrl = rtrim($disk->url(''), '/');
                $relativePath = str_replace($baseUrl . '/', '', $this->attachmentPath);

                if ($disk->exists($relativePath)) {
                    $mail->attachData(
                        $disk->get($relativePath),
                        'payment-proof.' . pathinfo($relativePath, PATHINFO_EXTENSION),
                        [
                            'mime' => $disk->mimeType($relativePath),
                        ]
                    );
                }

            }
            elseif (file_exists(public_path($this->attachmentPath))) {

                $mail->attach(
                    public_path($this->attachmentPath),
                    [
                        'as' => 'payment-proof.' . pathinfo($this->attachmentPath, PATHINFO_EXTENSION),
                    ]
                );
            }
        }

        return $mail;
    }
}
