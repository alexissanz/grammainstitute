<x-mail::message>
# {{ $mailSubject }}

{{ $mailMessage }}

---

**{{ $settings->nome_site ?? config('app.name') }}**

{{ $settings->email_institucional ?? '' }}

{{ $settings->telefone ?? '' }}

<x-mail::subcopy>
Este é um email institucional enviado pelo sistema {{ $settings->nome_site ?? config('app.name') }}.
</x-mail::subcopy>
</x-mail::message>
