@component('mail::message')
Introdução

Corpo da Mensagem

@component('mail::button', ['url' => ''])
Butão
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
