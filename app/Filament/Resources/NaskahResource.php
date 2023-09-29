<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Naskah;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\NaskahResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NaskahResource\RelationManagers;

class NaskahResource extends Resource
{
    protected static ?string $model = Naskah::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-alt';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()->schema([

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('thumbnail')
                    ->required()->image()->disk('public'),
                Forms\Components\RichEditor::make('content')
                    ->required(),
                Forms\Components\Select::make('post_as')->options([
                    'Surat Masuk'=>'Surat Masuk',
                    'Surat Keluar'=>'Surat Keluar',
                    'SK Camat' => 'SK Camat'    ]),    
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('post_as')->searchable(),
                Tables\Columns\TextColumn::make('link')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records){
                    foreach($records as $key => $value){
                        if($value->thumbnail){
                            Storage::disk('public')->delete($value->thumbnail);
                        }
                    }
                }),
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
            'index' => Pages\ListNaskahs::route('/'),
            'create' => Pages\CreateNaskah::route('/create'),
            'edit' => Pages\EditNaskah::route('/{record}/edit'),
        ];
    }    
}
