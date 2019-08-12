@component('mail::message')
# Сповіщення про анулювання Угоди на сайті HelpTop.com.ua

Угода №{!! $deal_code !!} аннульована з інціативи автора Послуги {!! $product_code_id !!} "{!! $service_title !!}".
В цій угоді Ви були:  {!! $initiator_seller_buyer !!}.
Автор послуги ( {!! $author_seller_buyer !!} ): {!! $author_name !!}.

Переглянути інформацію за аннульованою Угодою Ви можете за посиланням
@component('mail::button', ['url' => route('deals.show', $deal_id)])
Перейти
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent