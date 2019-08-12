@component('mail::message')
# Сповіщення про підтвердження етапу виконання Угоди №{!! $deal_code !!} на сайті HelpTop.com.ua

###Повідомляємо Вам, що за Угодою №{!! $deal_code !!}  {!! $you_contr_initiator !!}  {!! $accepted_initiator !!} етап "{!! $stage_deal !!}".

######В цій угоді Ви є ініціатором ( {!! $initiator_seller_buyer !!} ), оскільки обрали Послугу {!! $product_code_id !!} "{!! $service_title !!}".
######Автор угоди ( {!! $author_seller_buyer !!} ): {!! $author_name !!}.

{!! $accept_you_contr_initiator !!}.

{!! $deal_completed !!}

Детальніше за посланням:
@component('mail::button', ['url' => route('deals.edit', $deal_id)])
Перейти
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent
