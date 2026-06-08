<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Video;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VideoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VideoResource\RelationManagers;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')
            ->required()
            ->label(__('video title')),
            TextInput::make('video_url')
            ->url()
            ->required()
            ->label(__('video url')),
            Textarea::make('content')
            ->label(__('content'))
            ->required(),
            
            FileUpload::make('card_image')
            ->required()
            ->disk('public')
            ->directory('videos\thumb')
            ->label(__('video thumb')),
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
            ->label(__('video title'))
                ->searchable(),
            TextColumn::make('video_url')
            ->label(__('video url'))
            ->toggleable(isToggledHiddenByDefault: true),
            
            ImageColumn::make('card_image')
                ->label(__('video thumb')),
            TextColumn::make('content')
                ->label(__('content'))
                ->wrap()
                ->markdown()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('user.name')
                ->label(__('User Name'))
                ->searchable(),
            IconColumn::make('published')
            ->label(__('Product Status'))
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

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('view')
                    ->label(__('view'))
                    ->icon('heroicon-o-video-camera')
                    ->url(fn (Video $item): string => $item->video_url)
                    ->openUrlInNewTab(),
                Action::make('publish')
                    ->icon('heroicon-o-newspaper')
                    ->color('info')
                    ->label(function(Video $item){
                        if($item->published == false){
                            return __('publish');
                        }else{
                            return __('unpublish');
                        }
                    })
                    ->action(function(Video $item){
                        if($item->published == false){
                            $item->published = true;
                        }else{
                            $item->published = false;
                        }
                        $item->save();
                    }),
                
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Video');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Videos');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('Videos');
    }
}
