@component('mail::message')
# Приветствуем на сайте HelpTop.com.ua

###Благодарим за регистрацию! Теперь Вы можете выбрать на сайте одну из множества услуг и принять участие в торгах.

###Осталась небольшая формальность.
###Для активации аккаунта перейдите по ссылке: {!! $url !!}
###(или скопируйте ее в адресную строку браузера)

###Спасибо,<br>
###команда {{ config('app.name') }}


###Если это письмо пришло к Вам по ошибке - игнорируйте его.
###Письмо сформировано автоматически - не отвечайте на него.


######Thank you for registering! Now you can choose on the site one of the many services and take part in the auction. Remained a small formality. To activate your account, click on the link: {!! $url !!}. (or copy it to the address bar of the browser). If this letter came to you by mistake - ignore it.
@endcomponent
