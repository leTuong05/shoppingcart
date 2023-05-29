@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://shoping_cart.local:81/'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
