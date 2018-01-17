### Mautic API Helper

Requires the [Mautic Simple Mail](https://github.com/barnebys/MauticSimpleEmailBundle) plugin to be installed.

#### With basic auth

```
BarnebysMautic\Auth::initializeHttpBasic('username', 'password');
BarnebysMautic\Api::setBaseUrl('https://my.mautic.domain/api');
```

### With oauth

```
BarnebysMautic\Auth::initializeOAuth2
```

### Fetch a contact id by email
```
$data = BarnebysMautic\Api::getContactIdByMail('some@email.com');
```

### Other available methods
```
getContactIdByMail($mail)
sendToLead($mail, $templateId)
sendToContact($mail, $templateId)
```