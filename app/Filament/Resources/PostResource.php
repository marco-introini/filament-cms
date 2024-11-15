<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'posts';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                    ])->columns(1),
                Section::make('Content')
                    ->schema([
                        \Filament\Forms\Components\Builder::make('content')
                            ->blockPreviews()
                            ->blocks([
                                Block::make('title')
                                    ->label('Section Title')
                                    ->schema([
                                        TextInput::make('title')
                                            ->required(),
                                        Select::make('level')
                                            ->required()
                                            ->options([
                                                'h1' => 'Heading 1',
                                                'h2' => 'Heading 2',
                                                'h3' => 'Heading 3',
                                                'h4' => 'Heading 4',
                                                'h5' => 'Heading 5',
                                                'h6' => 'Heading 6',
                                            ])
                                    ])->preview('filament.content.block-previews.heading'),
                                Block::make('markdown')
                                    ->label('Section Content')
                                    ->schema([
                                        MarkdownEditor::make('markdown')
                                    ])
                                    ->preview('filament.content.block-previews.markdown'),
                            ])
                    ]),
                Section::make('Meta Information')
                    ->schema([
                        KeyValue::make('meta_description')
                    ]),
                Section::make('Images')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->disk('images'),
                    ]),
                Section::make('Visibility')
                    ->schema([
                        Checkbox::make('is_featured'),
                        Placeholder::make('published_at')
                            ->label('Published Date')
                            ->content(fn(?Post $record): string => $record?->published_at?->diffForHumans() ?? '-'),
                    ]),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Post $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Post $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content'];
    }
}
