@component('mail::message')
# Сповіщення про закінчення строку публікації послуги на сайті HelpTop.com.ua

Повідомляємо, що для послуги "{!! $service_title !!}" з товарним кодом ( {!! substr($product_code_id, 0, 6) . '-' . substr($product_code_id, 6, 4) !!} ) закінчився термін її публікації.

Далі Ваша послуга не буде показана на сайті і не буде доступна для ознайомлення іншим користувачам.

Перейти до даної послуги та поновити її публікацію Ви можете за посиланням
@component('mail::button', ['url' => route('service.show', $service_id)])
Перейти
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent
