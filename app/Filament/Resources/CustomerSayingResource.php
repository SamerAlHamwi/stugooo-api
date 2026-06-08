<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerSaying;
use Filament\Resources\Resource;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerSayingResource\Pages;
use App\Filament\Resources\CustomerSayingResource\RelationManagers;

class CustomerSayingResource extends Resource
{
    protected static ?string $model = CustomerSaying::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('customer')
            ->required()
            ->label(__('Name')),
            Textarea::make('content')
            ->label(__('Details'))
            ->required(),
            FileUpload::make('card_image')
            ->required()
            ->disk('public')
            ->directory('customer')
            ->label(__('Image')),
            Checkbox::make('published')
            ->label(__('status')),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('customer')                
            ->label(__('Name'))
            ->searchable(),
            ImageColumn::make('card_image')
            ->label(__('Image')),
            TextColumn::make('content')
                ->label(__('Details'))
                ->wrap()
                ->markdown()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false),
            IconColumn::make('published')
            ->label(__('status'))
                ->color(fn (string $state): string => match ($state) {
                    '1' => 'success',
                    '0' => 'danger',
                    default => 'danger',
                }), 
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCustomerSayings::route('/'),
            'create' => Pages\CreateCustomerSaying::route('/create'),
            'edit' => Pages\EditCustomerSaying::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return __('Our team');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Our team');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('Our team');
    }

}
