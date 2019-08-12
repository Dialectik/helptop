@component('mail::message')
# Сповіщення про нові (непрочитані) повідомлення від користувачів

Повідомляємо, що у Вас з'явилися нові повідомлення від користувачів.
Зокрема є непрочитане повідомлення щодо послуги "{!! $service_title !!}" з товарним кодом ( {!! substr($product_code_id, 0, 6) . '-' . substr($product_code_id, 6, 4) !!} ).

@component('mail::button', ['url' => route('messages.index')])
Перейти до повідомлень
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent
