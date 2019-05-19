@component('mail::message')
<span style="color:red; font-size: 150%">**Превышен лимит!!!**</span>


Превышен лимит количества объявлений услуг (более 8000) для вида услуг:  **{{ $kind_id }}** - **{{ $kind }}**  

@component('mail::button', ['url' => route('login')])
Перейти на страницу входа
@endcomponent

Просьба принять меры,<br>
{{ config('app.name') }}
@endcomponent
