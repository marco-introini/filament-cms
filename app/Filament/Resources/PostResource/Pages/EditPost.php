<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
            Action::make('publish')
                ->requiresConfirmation()
                ->action(fn (Post $record) => $record->publish())
                ->after(function (Post $record) {
                    Notification::make()
                        ->success()
                        ->title('Post Published')
                        ->body("$record->title is now LIVE")
                        ->send();
                })
                ->visible(fn(Post $record) => !$record->is_published),
            Action::make('unpublish')
                ->requiresConfirmation()
                ->action(fn (Post $record) => $record->unpublish())
                ->after(function (Post $record) {
                    Notification::make()
                        ->success()
                        ->title('Post UnPublished')
                        ->body("$record->title is now HIDDEN")
                        ->send();
                })
                ->visible(fn(Post $record) => $record->is_published),
        ];
    }
}
