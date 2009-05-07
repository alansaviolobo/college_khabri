Hi {$user->username()},

Welcome to College Khabri!
your account has been successfully setup and you are just 1 click away
from accessing a wealth of information regarding the engineering
admission process.

click on this link to activate your account.
{php}echo base_url(){/php}/members/activation/{$user->id()}

and enter this code: {$user->lastTx()->code()}

Best Regards,
The College Khabri Team