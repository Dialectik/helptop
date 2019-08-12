@component('mail::message')
# Сповіщення про створення нової Угоди на сайті HelpTop.com.ua

На сайті HelpTop.com.ua зареєстровано нову Угоду №{!! $deal_code !!}.

Угоду сформовано з Вашої інціативи шляхом обирання на сайті Послуги {!! $product_code_id !!} "{!! $service_title !!}".
В цій угоді Ви є:  {!! $initiator_seller_buyer !!}.
Автор послуги ( {!! $author_seller_buyer !!} ): {!! $author_name !!}.
Тип торгів: &nbsp;{!! $bidding_title !!}.
Короткий опис послуги:  {!! $service_description !!}. 
Послуга повинна бути {!! $initiator_granted_received !!}: в період: &nbsp; з {!! $date_initial_user !!} по {!! $date_deadline_user !!}.
Оплата послуги:&nbsp; {!! $payment !!}.  &nbsp;&nbsp; Послуга повинна бути оплачена в період: з {!! $date_initial_user !!} по {!! $date_deadline_pay !!}.

Перейдіть за послиланням для детального ознайомлення
@component('mail::button', ['url' => route('deals.edit', $deal_id)])
Перейти
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent