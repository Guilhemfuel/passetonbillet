<!-- Quantcast Choice. Consent Manager Tag -->
<script type="text/javascript" async=true>
    var elem = document.createElement('script');
    elem.src = 'https://quantcast.mgr.consensu.org/cmp.js';
    elem.async = true;
    elem.type = "text/javascript";
    var scpt = document.getElementsByTagName('script')[0];
    scpt.parentNode.insertBefore(elem, scpt);
    (function () {
        var gdprAppliesGlobally = true;

        function addFrame() {
            if (!window.frames['__cmpLocator']) {
                if (document.body) {
                    var body = document.body,
                        iframe = document.createElement('iframe');
                    iframe.style = 'display:none';
                    iframe.name = '__cmpLocator';
                    body.appendChild(iframe);
                } else {
                    // In the case where this stub is located in the head,
                    // this allows us to inject the iframe more quickly than
                    // relying on DOMContentLoaded or other events.
                    setTimeout(addFrame, 5);
                }
            }
        }

        addFrame();

        function cmpMsgHandler(event) {
            var msgIsString = typeof event.data === "string";
            var json;
            if (msgIsString) {
                json = event.data.indexOf("__cmpCall") != -1 ? JSON.parse(event.data) : {};
            } else {
                json = event.data;
            }
            if (json.__cmpCall) {
                var i = json.__cmpCall;
                window.__cmp(i.command, i.parameter, function (retValue, success) {
                    var returnMsg = {
                        "__cmpReturn": {
                            "returnValue": retValue,
                            "success": success,
                            "callId": i.callId
                        }
                    };
                    event.source.postMessage(msgIsString ?
                        JSON.stringify(returnMsg) : returnMsg, '*');
                });
            }
        }

        window.__cmp = function (c) {
            var b = arguments;
            if (!b.length) {
                return __cmp.a;
            }
            else if (b[0] === 'ping') {
                b[2]({
                    "gdprAppliesGlobally": gdprAppliesGlobally,
                    "cmpLoaded": false
                }, true);
            } else if (c == '__cmp')
                return false;
            else {
                if (typeof __cmp.a === 'undefined') {
                    __cmp.a = [];
                }
                __cmp.a.push([].slice.apply(b));
            }
        }
        window.__cmp.gdprAppliesGlobally = gdprAppliesGlobally;
        window.__cmp.msgHandler = cmpMsgHandler;
        if (window.addEventListener) {
            window.addEventListener('message', cmpMsgHandler, false);
        }
        else {
            window.attachEvent('onmessage', cmpMsgHandler);
        }
    })();
    if (window.locale == 'fr') {
        window.__cmp('init', {
            'Language': window.locale,
            'Initial Screen Title Text': 'Le respect de votre vie privée est notre priorité',
            'Initial Screen Reject Button Text': 'JE N’ACCEPTE PAS',
            'Initial Screen Accept Button Text': 'J&#039;ACCEPTE',
            'Initial Screen Purpose Link Text': 'Afficher les objectifs',
            'Purpose Screen Title Text': 'Le respect de votre vie privée est notre priorité',
            'Purpose Screen Body Text': 'Vous pouvez définir ci-dessous vos préférences de consentement et déterminer la manière dont vous souhaitez que vos données soient utilisées en fonction des objectifs mentionnés. Vous pouvez définir vos préférences pour notre société, indépendamment de celles de nos partenaires tiers. Chaque objectif est décrit afin que vous sachiez comment nos partenaires et nous-mêmes exploitons vos données.',
            'Purpose Screen Vendor Link Text': 'Consulter les fournisseurs',
            'Purpose Screen Cancel Button Text': 'Annuler',
            'Purpose Screen Save and Exit Button Text': 'Enregistrer et quitter',
            'Vendor Screen Title Text': 'Le respect de votre vie privée est notre priorité',
            'Vendor Screen Body Text': 'Vous pouvez définir ci-dessous vos préférences de consentement pour les partenaires tiers avec lesquels nous collaborons. Développez chaque élément de la liste des sociétés afin de découvrir l’objectif de ce traitement de données et de préciser votre choix. Dans certains cas, les sociétés peuvent exploiter vos données sans demander votre consentement, sur la base de leurs intérêts légitimes. Vous pouvez cliquer sur les liens relatifs à leur politique de confidentialité afin d’obtenir plus d’informations et de vous opposer à un tel traitement si vous le désirez.',
            'Vendor Screen Accept All Button Text': 'TOUT ACCEPTER',
            'Vendor Screen Reject All Button Text': 'TOUT REFUSER',
            'Vendor Screen Purposes Link Text': 'Retour aux objectifs',
            'Vendor Screen Cancel Button Text': 'Annuler',
            'Vendor Screen Save and Exit Button Text': 'Enregistrer et quitter',
            'Initial Screen Body Text': 'Nos partenaires et nous-mêmes exploitons différentes technologies, telles que celle des cookies, et traitons vos données à caractère personnel, telles que les adresses IP et les identifiants de cookie, afin de personnaliser les publicités et les contenus en fonction de vos centres d’intérêt, d’évaluer la performance de ces publicités et contenus, et de recueillir des informations sur les publics qui les ont visionnés. Cliquez ci-dessous si vous consentez à l’utilisation de cette technologie et au traitement de vos données à caractère personnel en vue de ces objectifs. Vous pouvez changer d’avis et modifier votre consentement à tout moment en revenant sur ce site.',
            'Initial Screen Body Text Option': 1,
            'Publisher Name': 'PasseTonBillet',
            'Publisher Logo': 'https://www.passetonbillet.fr/img/logo-black.png',
            'Display UI': 'always',
            'Publisher Purpose IDs': [5],
            'Post Consent Page': 'https://www.passetonbillet.fr/privacy',
            'UI Layout': 'banner',
        });
    } else {
        window.__cmp('init', {
            'Language': window.locale,
            'Initial Screen Reject Button Text': 'I DO NOT ACCEPT',
            'Initial Screen Accept Button Text': 'I ACCEPT',
            'Purpose Screen Body Text': 'You can set your consent preferences and determine how you want your data to be used based on the purposes below. You may set your preferences for us independently from those of third-party partners. Each purpose has a description so that you know how we and partners use your data.',
            'Purpose Screen Vendor Link Text': 'See Vendors',
            'Purpose Screen Save and Exit Button Text': 'SAVE &amp; EXIT',
            'Vendor Screen Body Text': 'You can set consent preferences for individual third-party partners we work with below. Expand each company list item to see what purposes they use data for to help make your choices. In some cases, companies may use your data without asking for your consent, based on their legitimate interests. You can click on their privacy policy links for more information and to object to such processing. ',
            'Vendor Screen Accept All Button Text': 'ACCEPT ALL',
            'Vendor Screen Reject All Button Text': 'REJECT ALL',
            'Vendor Screen Purposes Link Text': 'Back to Purposes',
            'Vendor Screen Save and Exit Button Text': 'SAVE &amp; EXIT',
            'Initial Screen Body Text': 'We and our partners use technologies, such as cookies, and process personal data, such as IP addresses and cookie identifiers, to personalise ads and content based on your interests, measure the performance of ads and content, and derive insights about the audiences who saw ads and content. Click below to consent to the use of this technology and the processing of your personal data for these purposes. You can change your mind and change your consent choices at any time by returning to this site. ',
            'Initial Screen Body Text Option': 1,
            'Publisher Name': 'PasseTonBillet',
            'Publisher Logo': 'https://www.passetonbillet.fr/img/logo-black.png',
            'Display UI': 'always',
            'Publisher Purpose IDs': [5],
            'Post Consent Page': 'https://www.passetonbillet.fr/privacy',
            'UI Layout': 'banner',
        });
    }
</script>
<!-- End Quantcast Choice. Consent Manager Tag -->
<style>
    .qc-cmp-button {
        background-color: #ff9600 !important;
        border-color: #ff9600 !important;
    }

    .qc-cmp-button:hover {
        background-color: transparent !important;
        border-color: #ff9600 !important;
        color: #ff9600 !important;
    }

    .qc-cmp-alt-action,
    .qc-cmp-link {
        color: #ff9600 !important;
    }

    .qc-cmp-button.qc-cmp-secondary-button:hover {
        border-color: transparent !important;
        background-color: #ff9600 !important;
    }

    .qc-cmp-button {
        color: #FFFFFF !important;
    }

    .qc-cmp-button.qc-cmp-secondary-button {
        color: #FFFFFF !important;
    }

    .qc-cmp-button.qc-cmp-button.qc-cmp-secondary-button:hover {
        color: #ffffff !important;
    }

    .qc-cmp-button.qc-cmp-secondary-button {
        border-color: #3caefd !important;
        background-color: #3caefd !important;
    }

    .qc-cmp-ui,
    .qc-cmp-ui .qc-cmp-main-messaging,
    .qc-cmp-ui .qc-cmp-messaging,
    .qc-cmp-ui .qc-cmp-beta-messaging,
    .qc-cmp-ui .qc-cmp-title,
    .qc-cmp-ui .qc-cmp-sub-title,
    .qc-cmp-ui .qc-cmp-purpose-info,
    .qc-cmp-ui .qc-cmp-table,
    .qc-cmp-ui .qc-cmp-table-header,
    .qc-cmp-ui .qc-cmp-vendor-list,
    .qc-cmp-ui .qc-cmp-vendor-list-title {
        color: #000000 !important;
    }

    .qc-cmp-ui a,
    .qc-cmp-ui .qc-cmp-alt-action {
        color: #ff9600 !important;
    }

    .qc-cmp-ui {
        background-color: #ffffff !important;
    }

    .qc-cmp-publisher-purposes-table .qc-cmp-table-header {
        background-color: #fafafa !important;
    }

    .qc-cmp-publisher-purposes-table .qc-cmp-table-row {
        background-color: #ffffff !important;
    }

    .qc-cmp-small-toggle.qc-cmp-toggle-on,
    .qc-cmp-toggle.qc-cmp-toggle-on {
        background-color: #ff9600 !important;
        border-color: #ff9600 !important;
    }
</style>