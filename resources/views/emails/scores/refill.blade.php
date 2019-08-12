@component('mail::message')
# Реквізити для поповнення рахунку №{!! $score->id !!} на сайті HelpTop.com.ua

Шановний користувач, Ви замовили поповнення рахунку на HelpTop.com.ua для можливості оплати сервісів сайту.

Номер рахунку, який Вам виставлено **№{!! $score->id !!}**.

Для сплати цього рахунку скористайтесь наступним способом:
 - поповнення карти ПриватБанку: **4731 1856 0749 3001** (Білоусов Євгеній)
 
 
При оплаті вказуйте рахунок **№{!! $score->id !!}** в примітках до платежу.
Також бажано повідомити через **контактну форму**:
 - № виставленого рахунку
 - сума
 - час оплати

Це **прискорить** зарахування коштів на рахунок HelpTop
@component('mail::button', ['url' => route('contacts')]) 
Перейти до контактної форми
@endcomponent


Дякуємо,<br>
команда {{ config('app.name') }}

Лист сформовано автоматично - не відповідайте на нього.
@endcomponent