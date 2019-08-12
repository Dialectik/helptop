@component('mail::message')
# Сповіщення про анулювання Угоди на сайті HelpTop.com.ua

Ви анулювали Угоду №{!! $deal_code !!} як автор об'яви ( {!! $author_seller_buyer !!} ) Послуги {!! $product_code_id !!} "{!! $service_title !!}".

Ініціатором угоди був ( {!! $initiator_seller_buyer !!} ): {!! $initiator_name !!}.

Переглянути інформацію за аннульованою Угодою Ви можете за посиланням
@component('mail::button', ['url' => route('deals.show', $deal_id)])
Перейти
@endcomponent

Аннульовану Угоду Ви можете видалити, знайшовши в переліку всіх угод Вашого профілю за її номером.


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent