<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
 use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class Settings extends Page implements HasForms // adding implements
{
    use InteractsWithForms; // adding trait

    protected static ?int $navigationSort = 1;

    public ?array $data = []; // for updating state data
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    //adding mount() for filling data in form from data array called in statePath
    public function mount(){
        $this->form->fill();
    }
    //adding form()
    public function form(Form $form):Form{

        $settings = Setting::first();
        $user = auth()->user(); 
        return $form->schema([
             Section::make(__('Language'))
            ->schema([
                Select::make('locale')
                    ->label(__('Choose Language'))
                    ->options([
                        'en' => 'English',
                        'tr' => 'turkish',
                        'ar' => 'العربية',
                    ])
                    ->default($settings->locale ?? config('app.locale'))
                    ->required()
                    ->live() // مهم جدًا: يجعل الحقل يتفاعل فورًا مع التغييرات
            ->afterStateUpdated(function (string $state) {
                // 1. تحديث قيمة الـ locale في قاعدة البيانات
                // افترض أن لديك نموذج Settings وأن هناك سجل واحد فقط للإعدادات العامة
                $setting = \App\Models\Setting::firstOrNew([]); // لإنشاء سجل إذا لم يكن موجودًا
                $setting->locale = $state;
                $setting->save();

                // 2. تحديث لغة التطبيق ليعكس التغيير فورًا
                app()->setLocale($state);

                // 3. (اختياري) تحديث الصفحة لإعادة تحميل المكونات بواجهة المستخدم الجديدة
                // هذا سيجعل ترجمات الواجهة تتغير فورًا دون تحديث يدوي للمتصفح.
                // Filament يفضل استخدام Notifications أو Livewire events للتفاعل،
                // لكن لإعادة تحميل الصفحة بالكامل، يمكنك استخدام:
                 redirect(request()->header('referer')); // يعيد توجيه لنفس الصفحة
                // أو
                // return redirect(url()->current()); // يعيد توجيه للصفحة الحالية
                // أو
                // return redirect(request()->url());
                // أو الأبسط: تحديث مكون Livewire
                // $this->dispatchBrowserEvent('refresh-page'); // إذا كان لديك مستمع لهذا الحدث
            }),
            
            ]),
            Section::make(__('main section'))
            ->schema([
                TextInput::make('main_title')->required()->label(__('main title'))
                ->default($settings->main_title ?? null),
                Textarea::make('main_content')->required()->label(__('main content'))
                ->default($settings->main_content ?? null),
            ]),
            Section::make(__('company vision'))
            ->schema([
                Textarea::make('vision_1')->required()->label(__('vision 1'))
                ->default($settings->vision_1 ?? null),
                Textarea::make('vision_2')->required()->label(__('vision 2'))
                ->default($settings->vision_2 ?? null),
                Textarea::make('vision_3')->required()->label(__('vision 3'))
                ->default($settings->vision_3 ?? null),
                Textarea::make('vision_4')->required()->label(__('vision 4'))
                ->default($settings->vision_4 ?? null),
                Textarea::make('vision_5')->required()->label(__('vision 5'))
                ->default($settings->vision_5 ?? null),
                Textarea::make('vision_6')->required()->label(__('vision 6'))
                ->default($settings->vision_6 ?? null),

            ])->columns(2),
            Section::make(__('cards counts'))
            ->schema([
                TextInput::make('products_count')->required()->label(__('products count'))
                ->numeric()
                ->minValue(1)
                ->maxValue(6)
                ->default($settings->products_count ?? 1),
                TextInput::make('posts_count')->required()->label(__('posts count'))
                ->numeric()
                ->minValue(1)
                ->maxValue(6)
                ->default($settings->posts_count ?? 5),
                TextInput::make('customers_count')->required()->label(__('customers count'))
                ->numeric()
                ->minValue(1)
                ->maxValue(6)
                ->default($settings->customers_count ?? 3),
                TextInput::make('videos_count')->required()->label(__('videos count'))
                ->numeric()
                ->minValue(1)
                ->maxValue(3)
                ->default($settings->videos_count ?? 1),
            ])->columns(4),
            Section::make(__('contacts section'))
            ->schema([
                TextInput::make('facebook_url')->required()->label(__('facebook url'))
                ->url()
                ->default($settings->facebook_url ?? null),
                TextInput::make('whatsapp_url')->required()->label(__('whatsapp url'))
                ->url()
                ->default($settings->whatsapp_url ?? null),
                TextInput::make('telegram_url')->required()->label(__('telegram url'))
                ->url()
                ->default($settings->telegram_url ?? null),

                TextInput::make('youtube_url')->required()->label(__('youtube url'))
                ->url()
                ->default($settings->youtube_url ?? null),
                TextInput::make('instagram_url')->required()->label(__('instagram url'))
                ->url()
                ->default($settings->instagram_url ?? null),
                TextInput::make('tiktok_url')->required()->label(__('tiktok url'))
                ->url()
                ->default($settings->tiktok_url ?? null),


                TextInput::make('company_email')->required()->label(__('company email'))
                ->email()
                ->default($settings->company_email ?? null),
                TextInput::make('company_phone')->required()->label(__('company phone'))
                ->tel()
                ->default($settings->company_phone ?? null),
                TextInput::make('company_mobile')->required()->label(__('company mobile'))
                ->tel()
                ->default($settings->company_mobile ?? null),
                TextInput::make('company_address')->required()->label(__('company address'))
                ->default($settings->company_address ?? null)
                ->columnSpanFull(),
                MarkdownEditor::make('office_hours')->required()->label(__('office hours'))
                ->default($settings->office_hours ?? null)
                ->columnSpanFull(),
                
            ])->columns(3),
            Section::make()
            ->schema([
                MarkdownEditor::make('footer')->required()->label(__('Footer'))
                ->default($settings->footer ?? null),
            ]),

            Section::make()
            ->schema([
                MarkdownEditor::make('be_partner')->required()->label(__('Be a partner'))
                ->default($settings->be_partner ?? null),
            ]),

        ])
        ->statePath('data'); // statePath , array data for get data in state
    }

    //this action called from action blade component
    protected function getFormActions(): array{
        return [
            Action::make('save')->submit('save')
        ];
    }

    // function called from blade form
    public function save(){
        try{
            // bring inputs data array
            $data = $this->form->getState();
            $settings = Setting::first();
            if(!$settings){
                Setting::create($data);
            }else{
                $settings->update($data); 
            }


            Notification::make()
            ->title(__('Saved successfully'))
            ->success()
            ->send();
            
        }catch(Halt $ex){
            return;
        }
    }

    public function getTitle(): string 
    {
        return __('Settings');
    }
    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

}
