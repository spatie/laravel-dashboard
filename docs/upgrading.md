---
title: Upgrading
weight: 5
---

## From v2 to v3

This release supports Livewire v3. There are no other breaking changes

If you have any error, you can check livewire 3 upgrade guide https://livewire.laravel.com/docs/upgrading

You can also try the command which can help if you have have created some custom iiles (->emit() became ->dispatch() for example)

```php artisan livewire:upgrade```

Don't forget to specify your APP_URL in .env, and to clear cache, config, etc... with ```php artisan optimize:clear```
