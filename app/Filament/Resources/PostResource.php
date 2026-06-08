<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Policies\PostPolicy;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->required()
                ->label(__('blog title')),
                TextInput::make('summary')
                ->required()
                ->label(__('summary')),
                MarkdownEditor::make('content')
                ->label(__('content'))
                ->required()
                ->columnSpanFull(),
                FileUpload::make('main_image')
                ->required()
                ->label(__('main image'))
                ->disk('public')
                ->directory('posts')
                ->image()
                //->imageCropAspectRatio('20:5')
                ->imageEditor()
                ->imageEditorAspectRatios(['20:5', '4:3', '1:1'])
                ,
                FileUpload::make('card_image')
                ->required()
                ->disk('public')
                ->directory('posts')
                ->label(__('card image'))
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios(['4:3', '1:1']),
                TagsInput::make('tags')
                ->columnSpanFull()
                ->label(__('tags')),
                Checkbox::make('published')
                ->label(__('status')),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')                
                    ->label(__('blog title'))
                    ->searchable(),
                TextColumn::make('summary')
                    ->label(__('summary'))
                    ->wrap()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('card_image')
                    ->label(__('card image')),
                TextColumn::make('user.name')
                    ->label(__('User Name'))
                    ->searchable(),
                IconColumn::make('published')
                ->label(__('status'))
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label(__('Published On'))
                    ->sortable()
                    ->since()
                    ->dateTimeTooltip()     
                    ,             
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Action::make('publish')
                ->icon('heroicon-o-newspaper')
                ->color('info')
                ->label(function(Post $post){
                    if($post->published == false){
                        return __('publish');
                    }else{
                        return __('unpublish');
                    }
                })
                ->action(function(Post $post){
                    if($post->published == false){
                        $post->published = true;
                    }else{
                        $post->published = false;
                    }
                    $post->save();
                })->authorize('publish', Post::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    

                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('post');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('posts');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('posts');
    }

    public static function getWidgets(): array
{
    return [
        //PostResource\Widgets\PostOverview::class,
    ];
}

}
