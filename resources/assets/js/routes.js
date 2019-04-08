var Ziggy = {
    namedRoutes: {
        "debugbar.openhandler": {"uri": "_debugbar\/open", "methods": ["GET", "HEAD"], "domain": null},
        "debugbar.clockwork": {"uri": "_debugbar\/clockwork\/{id}", "methods": ["GET", "HEAD"], "domain": null},
        "debugbar.assets.css": {"uri": "_debugbar\/assets\/stylesheets", "methods": ["GET", "HEAD"], "domain": null},
        "debugbar.assets.js": {"uri": "_debugbar\/assets\/javascript", "methods": ["GET", "HEAD"], "domain": null},
        "debugbar.cache.delete": {"uri": "_debugbar\/cache\/{key}\/{tags?}", "methods": ["DELETE"], "domain": null},
        "eyewitness.dashboard": {"uri": "eyewitness\/dashboard", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.schedulers.show": {
            "uri": "eyewitness\/schedulers\/{id}",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.schedulers.update": {"uri": "eyewitness\/schedulers\/{id}", "methods": ["PUT"], "domain": null},
        "eyewitness.schedulers.destroy": {"uri": "eyewitness\/schedulers\/{id}", "methods": ["DELETE"], "domain": null},
        "eyewitness.settings.index": {"uri": "eyewitness\/settings", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.severity.update": {"uri": "eyewitness\/severity", "methods": ["PUT"], "domain": null},
        "eyewitness.recipients.create": {
            "uri": "eyewitness\/recipients\/create",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.recipients.destroy": {"uri": "eyewitness\/recipients\/{id}", "methods": ["DELETE"], "domain": null},
        "eyewitness.recipients.test": {
            "uri": "eyewitness\/recipients\/{id}\/test",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.email": {
            "uri": "eyewitness\/recipients\/create\/email",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.slack": {
            "uri": "eyewitness\/recipients\/create\/slack",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.nexmo": {
            "uri": "eyewitness\/recipients\/create\/nexmo",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.hipchat": {
            "uri": "eyewitness\/recipients\/create\/hipchat",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.webhook": {
            "uri": "eyewitness\/recipients\/create\/webhook",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.pushover": {
            "uri": "eyewitness\/recipients\/create\/pushover",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.recipients.create.pagerduty": {
            "uri": "eyewitness\/recipients\/create\/pagerduty",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.notifications.show": {
            "uri": "eyewitness\/notifications\/{id}",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.notifications.update": {
            "uri": "eyewitness\/notifications\/{id}",
            "methods": ["PUT"],
            "domain": null
        },
        "eyewitness.dns.show": {"uri": "eyewitness\/dns", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.queues.show": {"uri": "eyewitness\/queues\/{id}", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.queues.update": {"uri": "eyewitness\/queues\/{id}", "methods": ["PUT"], "domain": null},
        "eyewitness.queues.destroy": {"uri": "eyewitness\/queues\/{id}", "methods": ["DELETE"], "domain": null},
        "eyewitness.failedjob.show": {
            "uri": "eyewitness\/failedjob\/{queue_id}\/{job_id}",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.failedjob.retry": {
            "uri": "eyewitness\/failedjob\/{queue_id}\/{job_id}",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.failedjob.destroy": {
            "uri": "eyewitness\/failedjob\/{queue_id}\/{job_id}",
            "methods": ["DELETE"],
            "domain": null
        },
        "eyewitness.failedjob.retry-all": {
            "uri": "eyewitness\/failedjob\/{queue_id}",
            "methods": ["POST"],
            "domain": null
        },
        "eyewitness.failedjob.destroy-all": {
            "uri": "eyewitness\/failedjob\/{queue_id}",
            "methods": ["DELETE"],
            "domain": null
        },
        "eyewitness.debug.index": {"uri": "eyewitness\/debug", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.asset.css": {
            "uri": "eyewitness\/asset\/{cache_buster}\/eyewitness.css",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.asset.js": {
            "uri": "eyewitness\/asset\/{cache_buster}\/eyewitness.js",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "eyewitness.login": {"uri": "eyewitness", "methods": ["GET", "HEAD"], "domain": null},
        "eyewitness.authenticate": {"uri": "eyewitness", "methods": ["POST"], "domain": null},
        "eyewitness.logout": {"uri": "eyewitness\/logout", "methods": ["POST"], "domain": null},
        "home": {"uri": "\/", "methods": ["GET", "HEAD"], "domain": null},
        "home-redirect": {"uri": "home", "methods": ["GET", "HEAD"], "domain": null},
        "lang.js": {"uri": "lang\/lang-{locale}.js", "methods": ["GET", "HEAD"], "domain": null},
        "lang": {"uri": "lang\/{lang}", "methods": ["GET", "HEAD"], "domain": null},
        "register.page": {"uri": "register", "methods": ["GET", "HEAD"], "domain": null},
        "register": {"uri": "register", "methods": ["POST"], "domain": null},
        "register.verify-email": {"uri": "verify-email\/{token}", "methods": ["GET", "HEAD"], "domain": null},
        "login.page": {"uri": "login", "methods": ["GET", "HEAD"], "domain": null},
        "login": {"uri": "login", "methods": ["POST"], "domain": null},
        "logout": {"uri": "logout", "methods": ["GET", "HEAD"], "domain": null},
        "password.email_page": {"uri": "password\/reset", "methods": ["GET", "HEAD"], "domain": null},
        "password.reset.page": {"uri": "password\/reset\/{token?}", "methods": ["GET", "HEAD"], "domain": null},
        "password.post_email": {"uri": "password\/email", "methods": ["POST"], "domain": null},
        "password.reset.post_new_password": {"uri": "password\/reset", "methods": ["POST"], "domain": null},
        "fb.connect": {"uri": "register\/fb", "methods": ["GET", "HEAD"], "domain": null},
        "fb.callback": {"uri": "register\/fb\/callback", "methods": ["GET", "HEAD"], "domain": null},
        "fb.confirm": {"uri": "register\/fb\/confirm", "methods": ["POST"], "domain": null},
        "public.ticket.sell.page": {"uri": "ticket\/sell", "methods": ["GET", "HEAD"], "domain": null},
        "public.ticket.buy.page": {"uri": "ticket\/buy", "methods": ["GET", "HEAD"], "domain": null},
        "cgu.page": {"uri": "cgu", "methods": ["GET", "HEAD"], "domain": null},
        "privacy.page": {"uri": "privacy", "methods": ["GET", "HEAD"], "domain": null},
        "about.page": {"uri": "about", "methods": ["GET", "HEAD"], "domain": null},
        "help.page": {"uri": "help", "methods": ["GET", "HEAD"], "domain": null},
        "contact.page": {"uri": "contact", "methods": ["GET", "HEAD"], "domain": null},
        "contact": {"uri": "contact", "methods": ["POST"], "domain": null},
        "public.ticket.sell.post": {"uri": "ticket\/sell", "methods": ["POST"], "domain": null},
        "public.ticket.edit": {"uri": "ticket\/edit\/{ticket_id}", "methods": ["POST"], "domain": null},
        "public.ticket.owned.page": {"uri": "ticket\/owned\/{tab?}", "methods": ["GET", "HEAD"], "domain": null},
        "public.ticket.delete_or_sell": {"uri": "ticket", "methods": ["DELETE"], "domain": null},
        "public.ticket.download": {"uri": "ticket\/download\/{ticket_id}", "methods": ["GET", "HEAD"], "domain": null},
        "public.message.home.page": {"uri": "messages", "methods": ["GET", "HEAD"], "domain": null},
        "public.message.offer.deny": {"uri": "messages\/deny", "methods": ["POST"], "domain": null},
        "public.message.offer.accept": {"uri": "messages\/accept", "methods": ["POST"], "domain": null},
        "public.message.discussion.page": {
            "uri": "messages\/{ticket_id}\/{discussion_id}",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "public.message.discussion.sell": {
            "uri": "messages\/{ticket_id}\/{discussion_id}\/sell",
            "methods": ["POST"],
            "domain": null
        },
        "public.profile.stanger": {"uri": "profile\/user\/{user_id}", "methods": ["GET", "HEAD"], "domain": null},
        "public.profile.home": {"uri": "profile", "methods": ["GET", "HEAD"], "domain": null},
        "public.profile.phone.add": {"uri": "profile\/phone\/add", "methods": ["POST"], "domain": null},
        "public.profile.phone.verify": {"uri": "profile\/phone\/verify", "methods": ["POST"], "domain": null},
        "public.profile.password.change": {"uri": "profile\/password\/change", "methods": ["POST"], "domain": null},
        "public.profile.picture.upload": {"uri": "profile\/picture\/upload", "methods": ["POST"], "domain": null},
        "public.profile.id.upload": {"uri": "profile\/identity\/upload", "methods": ["POST"], "domain": null},
        "ticket.unique.page": {"uri": "ticket\/{ticket_id}", "methods": ["GET", "HEAD"], "domain": null},
        "image.ticket.preview": {"uri": "img\/ticket\/{ticket_id}.png", "methods": ["GET", "HEAD"], "domain": null},
        "api.tickets.buy": {"uri": "api\/tickets\/buy", "methods": ["GET", "HEAD"], "domain": null},
        "api.stations.search": {"uri": "api\/stations\/search", "methods": ["GET", "HEAD"], "domain": null},
        "api.stations.show": {"uri": "api\/stations\/{id}", "methods": ["GET", "HEAD"], "domain": null},
        "api.tickets.phone_number": {
            "uri": "api\/tickets\/{ticket}\/phone-number",
            "methods": ["GET", "HEAD"],
            "domain": null
        },
        "api.users.search": {"uri": "api\/users\/{name}", "methods": ["GET", "HEAD"], "domain": null},
        "api.notifications": {"uri": "api\/notifications", "methods": ["GET", "HEAD"], "domain": null},
        "api.tickets.search": {"uri": "api\/ticket\/search", "methods": ["POST"], "domain": null},
        "api.tickets.offer": {"uri": "api\/ticket\/offer", "methods": ["POST"], "domain": null},
        "api.tickets.offers": {"uri": "api\/ticket\/{ticket}\/offers", "methods": ["GET", "HEAD"], "domain": null},
        "api.discussion.send": {"uri": "api\/messages\/{ticket}\/{discussion}", "methods": ["POST"], "domain": null},
        "api.discussion.read": {
            "uri": "api\/messages\/{ticket}\/{discussion}\/read",
            "methods": ["POST"],
            "domain": null
        },
        "api.reviews.store": {"uri": "api\/reviews", "methods": ["POST"], "domain": null}
    },
    baseUrl: 'https://ptb.nahum/',
    baseProtocol: 'https',
    baseDomain: 'ptb.nahum',
    basePort: false,
    defaultParameters: []
};

if (typeof window.Ziggy !== 'undefined') {
    for (var name in window.Ziggy.namedRoutes) {
        Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
    }
}

export {
    Ziggy
}
