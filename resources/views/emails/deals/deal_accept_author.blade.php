@component('mail::message')
# Сповіщення про підтвердження етапу виконання Угоди №{!! $deal_code !!} на сайті HelpTop.com.ua

###Повідомляємо Вам, що за Угодою №{!! $deal_code !!}  {!! $you_contr_author !!}  {!! $accepted_author !!} виконання етапу "{!! $stage_deal !!}".

######В цій угоді Ви є автором об'яви ( {!! $author_seller_buyer !!} ) Послуги {!! $product_code_id !!} "{!! $service_title !!}".
######Ініціатор угоди ( {!! $initiator_seller_buyer !!} ): {!! $initiator_name !!}.

{!! $accept_you_contr_author !!}.

{!! $deal_completed !!}

Детальніше за посланням:
@component('mail::button', ['url' => route('deals.edit', $deal_id)])
Перейти
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent
