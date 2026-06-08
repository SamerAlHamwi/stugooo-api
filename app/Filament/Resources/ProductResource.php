<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->required()
                ->label(__('Product Name')),
                MarkdownEditor::make('content')
                ->label(__('Product Content'))
                ->required(),
                //->columnSpanFull(),
                FileUpload::make('image')
                ->required()
                ->label(__('Product Image'))
                ->disk('public')
                ->directory('products')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios(['4:3', '1:1'])
                //->maxSize(10000)
                ,
                TextInput::make('android_url')
                ->label(__('Android Url')),
                TextInput::make('ios_url')
                ->label(__('Ios Url')),

                TagsInput::make('tags')
                ->columnSpanFull()
                ->label(__('Tags')),
                Checkbox::make('published')
                ->label(__('Product Status')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')                
                    ->label(__('Product Name'))
                    ->searchable(),
                TextColumn::make('content')
                    ->label(__('Product Content'))
                    ->wrap()
                    ->markdown()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('image')
                    ->label(__('Product Image')),
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
                Action::make('publish')
                ->icon('heroicon-o-newspaper')
                ->color('info')
                ->label(function(Product $item){
                    if($item->published == false){
                        return __('publish');
                    }else{
                        return __('unpublish');
                    }
                })
                ->action(function(Product $item){
                    if($item->published == false){
                        $item->published = true;
                    }else{
                        $item->published = false;
                    }
                    $item->save();
                })->authorize('publish', Product::class),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Product');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

}
