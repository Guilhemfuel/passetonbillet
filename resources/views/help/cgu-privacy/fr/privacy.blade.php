@extends('layouts.app')

@section('content')

    <div class="privacy-page">

        <div class="section-header">
            <div class="first-section" style="background-image: url('{{secure_asset('img/bg/3.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{secure_asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo ptb">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">@lang('nav.login')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">@lang('nav.register')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if (App::isLocale('fr'))
                                <a class="nav-link" href="{{route('lang','en')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @else
                                <a class="nav-link" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div>
                            <h2 class="text-center text-white">Privacy Policy</h2>
                            <p class="text-center text-white">
                                Last updated: March 10, 2018
                            </p>
                            <div class="container container-over-bg p-5 mt-3 text-justify">

                                <h4 class="mt-3 pb-3">Comment nous collectons et utilisons vos informations
                                </h4>

                                <div>
                                    <p>Cette politique de confidentialité a été compilée pour mieux servir les
                                        qui s'inquiètent de la manière dont leurs «informations personnelles identifiables» (PII)
                                        être utilisé en ligne. PII, tel que décrit dans la loi américaine sur la confidentialité et la sécurité de l'information,
                                        est une information qui peut être utilisée seule ou avec d'autres informations
                                        identifier, contacter ou localiser une seule personne, ou identifier une personne
                                        le contexte. S'il vous plaît lire attentivement notre politique de confidentialité pour obtenir une compréhension claire
                                        de la façon dont nous collectons, utilisons, protégeons ou manipulons autrement votre identifiant personnel
                                        Informations conformément à notre site Web.</p>
                                    <p class='grayText'><strong>Quelles informations personnelles collectons-nous
                                            les gens qui visitent notre blog, site web ou application?</strong></p>
                                    <p>Lors de la commande ou de l'inscription sur notre site, le cas échéant, vous
                                        peut vous demander d'entrer votre nom, adresse e-mail, adresse postale, numéro de téléphone,
                                        Ville ou d'autres détails pour vous aider avec votre expérience.
                                    </p>

                                    <p class='grayText'><strong>Quand recueillons-nous des informations?</strong></p>
                                    <p>
                                        Nous recueillons des informations auprès de vous lorsque vous vous inscrivez sur notre
                                        site, passer une commande, s'abonner à un bulletin, répondre à un sondage, remplir un
                                        formulaire, utiliser Live Chat, ouvrir un ticket de support ou entrer des informations sur notre site.
                                    </p>

                                    <p class='grayText'><strong>Comment utilisons-nous vos informations?
                                        </strong></p>
                                    <p> Nous pouvons utiliser les informations que nous recueillons de vous lorsque vous
                                        inscrivez-vous, faites un achat, inscrivez-vous à notre newsletter, répondez à un sondage ou
                                        marketing, surfer sur le site Web ou utiliser certaines autres fonctionnalités du site
                                        les moyens suivants:</p>
                                    <ul>
                                        <li>
                                            Personnaliser votre expérience et nous permettre de livrer le type de contenu
                                            et
                                            offres de produits dans lesquelles vous êtes le plus intéressé.
                                        </li>
                                        <li>Améliorer notre site internet afin de mieux vous servir.
                                        </li>
                                        <li>Pour nous permettre de mieux vous servir en répondant à votre service client
                                            demandes
                                        </li>
                                        <li>Administrer un concours, une promotion, un sondage ou une autre caractéristique du site.
                                        </li>
                                        <li>Traitez rapidement vos transactions.
                                        </li>
                                        <li>Demander des évaluations de services ou de produits
                                        </li>
                                        <li>
                                            Faire un suivi avec eux après la correspondance (chat en direct, email ou téléphone
                                            demandes de renseignements)
                                        </li>
                                    </ul>
                                    <span id='infoPro'></span>
                                    <div class='grayText'><strong>Comment protégeons-nous vos informations?</strong></div>
                                    <p>Nous n'utilisons pas l'analyse de vulnérabilité et / ou la numérisation vers les normes PCI.
                                    </p>
                                    <p>Nous fournissons uniquement des articles et des informations. Nous ne demandons jamais
                                        numéros de carte de crédit.
                                    </p>
                                    <p>Nous n'utilisons pas la recherche de logiciels malveillants.</p>
                                    <p>Vos informations personnelles sont sauvegardées dans des
                                        réseaux sécurisé et accessible que par un nombre limité de personnes ayant des
                                        droits d'accès à ces systèmes, et tenus de conserver les informations
                                        confidentielles. En outre, toutes les informations sensibles que vous fournissez sont
                                        crypté via la technologie SSL (Secure Socket Layer).
                                    </p>

                                    <p>Nous mettons en œuvre une variété de mesures de sécurité lorsqu'un utilisateur
                                        place une commande entre, soumet ou accède à ses informations pour maintenir
                                        la sécurité de vos informations personnelles.
                                    </p>

                                    <p>Toutes les transactions sont traitées par un fournisseur de passerelle et
                                        ne sont pas stockés ou traités sur nos serveurs.
                                    </p>
                                    <span id='coUs'></span>
                                    <p class='grayText'><strong>
                                            Utilisons-nous des 'cookies'?</strong></p>
                                    <p>Oui. Les cookies sont de petits fichiers qu'un site ou son service
                                        le fournisseur transfère sur le disque dur de votre ordinateur via votre navigateur Web (si
                                        vous autorisez) qui permet aux systèmes du site ou du fournisseur de services de reconnaître
                                        votre navigateur et capturer et se souvenir de certaines informations. Par exemple, nous utilisons
                                        des cookies pour nous aider à mémoriser et traiter les articles dans votre panier. Ils
                                        sont également utilisés pour nous aider à comprendre vos préférences basées sur
                                        l'activité actuelle du site, ce qui nous permet de vous fournir des services améliorés.
                                        Nous utilisons également des cookies pour nous aider à compiler des données agrégées sur le trafic du site et
                                        l'interaction du site afin que nous puissions offrir de meilleures expériences de site et des outils dans le
                                        avenir.
                                    </p>
                                    <p><strong>Nous utilisons des cookies pour:</strong></p>
                                    <ul>
                                        <li>Permettre de
                                            mémoriser et traiter les articles dans le panier.
                                        </li>
                                        <li>Comprendre et enregistrer les préférences de l'utilisateur pour les prochaines visites.
                                        </li>
                                        <li>Mémoriser les contenus publicitaires.
                                        </li>
                                        <li>
                                            Compiler des données agrégées sur le trafic du site et les interactions du site afin d'offrir de meilleures expériences de site et de meilleurs outils dans le futur. Nous pouvons également utiliser
                                            des services de tiers de confiance qui suivent ces informations en notre nom.
                                        </li>
                                    </ul>
                                    <p>Yous pouvez choisir que votre ordinateur vous avertisse à chaque fois
                                        qu'un cookie est en cours d'envoi, ou vous pouvez choisir de désactiver tous les cookies. Vous pouvez faire cela
                                        grâce aux paramètres de votre navigateur. Comme les navigateur peuvent être un peu différent, nous vous conseillons de regarder votre
                                        menu d'aide du navigateur pour apprendre la bonne façon de modifier vos cookies.</p>
                                    <p><strong>Si les utilisateurs désactivent les cookies dans leur
                                            navigateur:</strong></p>

                                    <p>Si vous désactivez les cookies, certaines des fonctionnalités qui rendent
                                        l'expérience de site plus efficace peuvent ne pas fonctionner correctement.
                                    </p>
                                    <span id='trDi'></span>
                                    <div class='grayText'><strong>Third-party disclosure</strong></div>
                                    <p>We do not sell, trade, or otherwise transfer to outside
                                        parties your Personally Identifiable Information.
                                    </p>
                                    <span id='trLi'></span>
                                    <p class='grayText'><strong>Divulgation par des tiers</strong></p>
                                    <p>Occasionnellement, à notre discrétion, nous pouvons inclure ou offrir
                                        des produits ou services de tiers sur notre site Web. Ces sites tiers ont
                                        des politiques de confidentialité distinctes et indépendantes. Nous ne sommes donc en aucun cas responsables
                                        pour le contenu et les activités de ces sites liés. Toutefois,
                                        nous cherchons à protéger l'intégrité de notre site et à recevoir vos avis sur
                                        ces sites.
                                    </p>
                                    {{--<p class='grayText'><strong>Google</strong></p>--}}
                                    {{--<p>Google's advertising requirements can be summed up by--}}
                                    {{--Google's Advertising Principles. They are put in place to provide a positive--}}
                                    {{--experience for users.--}}
                                    {{--https://support.google.com/adwordspolicy/answer/1316548?hl=en </p>--}}
                                    {{--<p>We use Google AdSense Advertising on our website.</p>--}}
                                    {{--<p>Google, as a third-party vendor, uses cookies to serve--}}
                                    {{--ads on our site. Google's use of the DART cookie enables it to serve ads to our--}}
                                    {{--users based on previous visits to our site and other sites on the Internet.--}}
                                    {{--Users may opt-out of the use of the DART cookie by visiting the Google Ad and--}}
                                    {{--Content Network privacy policy.</p>--}}
                                    {{--<p><strong>We have implemented the following:</strong></p>--}}
                                    {{--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>&bull;</strong>--}}
                                    {{--Remarketing with Google AdSense--}}
                                    {{--</p>--}}
                                    {{--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>&bull;</strong> Google--}}
                                    {{--Display Network Impression Reporting--}}
                                    {{--</p>--}}
                                    {{--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>&bull;</strong>--}}
                                    {{--Demographics and Interests Reporting--}}
                                    {{--</p>--}}
                                    {{--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>&bull;</strong>--}}
                                    {{--DoubleClick Platform Integration</p>--}}

                                    {{--<p>We, along with third-party vendors such as Google use--}}
                                    {{--first-party cookies (such as the Google Analytics cookies) and third-party--}}
                                    {{--cookies (such as the DoubleClick cookie) or other third-party identifiers--}}
                                    {{--together to compile data regarding user interactions with ad impressions and--}}
                                    {{--other ad service functions as they relate to our website.--}}
                                    {{--</p>--}}
                                    {{--<p><strong>Opting out:</strong>Users can set preferences--}}
                                    {{--for how Google advertises to you using the Google Ad Settings page.--}}
                                    {{--Alternatively, you can opt out by visiting the Network Advertising Initiative--}}
                                    {{--Opt Out page or by using the Google Analytics Opt Out Browser add on.--}}
                                    {{--</p>--}}
                                    <span id='calOppa'></span>
                                    <p class='grayText'><strong>Loi sur la protection de la vie privée en ligne
                                        </strong>
                                    </p>
                                    <p>CalOPPA est la première loi de la nation à exiger
                                        des sites commerciaux et services en ligne d'afficher une politique de confidentialité. La portée des lois s'étend bien au-delà de la Californie pour exiger qu'une personne ou une entreprise aux
                                        États-Unis (et peut-être le monde) qui exploite des sites Web de collecte
                                        d'informations personnellement identifiables des consommateurs californiens
                                       de publier une politique de confidentialité ostentatoire sur son site Web indiquant avec exactitude les informations
                                        recueillies et les personnes ou les entreprises avec lesquelles elle sont partagés. - Voir
                                        Plus à:
                                        <a target="_blank" href="http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf">http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</a>
                                    </p>
                                    <p>Selon CalOPPA, nous sommes d'accord avec sur les principes suivant:</p>
                                    <ul>
                                        <li>Les utilisateurs peuvent visiter le site de manière anonyme.</li>
                                        <li>Une fois cette politique de confidentialité créée, nous ajouterons un lien vers celle-ci
                                            sur notre page d'accueil.
                                        </li>
                                        <li>
                                            Notre lien de Politique de confidentialité inclut le mot "Confidentialité" et peut
                                            facilement se trouver sur la page spécifiée ci-dessus.
                                        </li>
                                    </ul>

                                    <p>
                                        Vous serez informé de toute modification de la politique de confidentialité:</p>
                                    <ul>
                                        <li>Sur notre
                                            page de Politique de confidentialité
                                        </li>
                                        <li>Via email
                                        </li>
                                    </ul>
                                    <p>Vous pouvez modifier vos informations personelles:</p>
                                    <ul>
                                        <li>En en envoyant un email

                                        </li>
                                        <li>En vous connectant sur votre compte
                                        </li>
                                        <li>En discuttant avec nous en live sur la plateforme
                                        </li>
                                    </ul>
                                    <p><strong>Comment notre site gère t-il les signaux à ne pas suivre?
                                        </strong></p>
                                    <p>
                                        Nous honorons les signaux Do Not Track et Do Not Track, plant
                                        cookies, ou utiliser la publicité lorsqu'un mécanisme de navigateur Ne pas suivre (DNT) est en
                                        endroit.
                                    </p>
                                    <p><strong>
                                            Est-ce que notre site permet le comportement de tiers
                                            suivi?</strong></p>
                                    <p>
                                        Il est également important de noter que nous autorisons les tiers
                                        suivi comportemental
                                    </p>
                                    <span id='coppAct'></span>
                                    <p class='grayText'><strong>COPPA (Acte de Protection de la vie privée des enfants en ligne)</strong></p>
                                    <p>Quand il s'agit de la collecte de renseignements personnels des enfants de moins de 13 ans, la protection de la vie privée des enfants en ligne
                                        La loi (COPPA) met les parents en responsables. La Federal Trade Commission, applique la règle de la COPPA, qui énonce
                                         que les opérateurs de sites Web et des services en ligne doivent faire pour protéger les enfants
                                        confidentialité et sécurité en ligne.</p>
                                    <p>Nous ne vendons pas spécifiquement aux enfants de moins de 13 ans
                                        ans.
                                    </p>
                                    <p>Laissons-nous des tiers, y compris des réseaux publicitaires ou des plug-ins
                                        recueillir des renseignements personnels sur les enfants de moins de 13 ans?
                                    </p>
                                    <span id='ftcFip'></span>
                                    <p class='grayText'><strong>Pratiques équitables d'information</strong></p>
                                    <p>Les principes de pratiques d'information équitables forment l'épine dorsale
                                        de la loi sur la vie privée aux États-Unis et les concepts qu'ils comprennent ont joué un
                                        rôle important dans le développement des lois sur la protection des données dans le monde entier.
                                        Comprendre les principes de pratiques d'information équitables et comment ils devraient être
                                        mis en œuvre est essentiel pour se conformer aux diverses lois sur la protection de la vie privée qui protègent
                                        informations personnelles.</p>
                                    <p><strong>Afin d'être en accord avec les informations justes
                                            Pratiques nous prendrons l'action réactive suivante, si une violation de données
                                            se produire:</strong></p>
                                    <div class="ml-5">
                                        <p>Nous vous informerons par e-mail</p>
                                        <ul>
                                            <li>En moins de
                                                7 jours ouvrables
                                            </li></ul>
                                        <p>Nous informerons les utilisateurs via les notifications sur site</p>
                                        <ul>
                                            <li>En moins de
                                                7 jours ouvrables
                                            </li></ul>
                                    </div>
                                    <p>Nous sommes également d'accord avec le principe de la réparation individuelle
                                        exige que les individus aient le droit de poursuivre légalement des droits exécutoires
                                        contre les collecteurs de données et les processeurs qui ne respectent pas la loi. Ce
                                        principe exige non seulement que les individus aient des droits opposables
                                        utilisateurs de données, mais aussi que les particuliers ont recours aux tribunaux ou au gouvernement
                                        agences pour enquêter et / ou poursuivre les non-conformités par les entreprises de traitement de données.
                                    </p>
                                    <span id='canSpam'></span>
                                    <p class='grayText'><strong>Loi CAN SPAM</strong></p>
                                    <p>La loi CAN-SPAM est une loi qui définit les règles pour les
                                        courrier électronique, établit des exigences pour les messages commerciaux, donne aux
                                        droit d'avoir des courriels arrêtés d'être envoyé à eux, et énonce dur
                                        pénalités pour les violations.</p>
                                    <p><strong>Nous collectons votre adresse email afin de:</strong>
                                    </p>
                                    <ul>
                                        <li>
                                            Envoyer
                                            des informations, répondre aux demandes, et / ou d'autres demandes ou questions.
                                        </li>
                                        <li>
                                            Traiter les commandes et envoyer des informations et des mises à jour relatives aux commandes.
                                        </li>
                                        <li>Envoyer des informations supplémentaires liées à votre produit et / ou service
                                        </li>
                                        <li>Vendre
                                            à notre liste de diffusion ou continuer à envoyer des courriels à nos clients après l'original
                                            la transaction a eu lieu.
                                        </li>
                                    </ul>
                                    <p><strong>
                                            Pour être en accord avec CANSPAM, nous acceptons :
                                        </strong></p>
                                    <ul>
                                        <li>Pas
                                            l'utilisation des sujets faux ou trompeurs ou des adresses email.
                                        </li>
                                        <li>

                                            Identifiez le message comme une publicité d'une manière raisonnable.
                                        </li>
                                        <li>
                                            Indiquez l'adresse physique de notre siège social ou de notre site.
                                        </li>
                                        <li>

                                            Surveiller la conformité des services de marketing par courriel d'une tierce partie, le cas échéant.
                                        </li>
                                        <li>Honnorer la désinscription / désinscription des demandes rapidement.
                                        </li>
                                        <li>Permettre
                                            aux utilisateurs à se désabonner en utilisant le lien en bas de chaque email.
                                        </li>
                                    </ul>
                                    <p><strong>
                                            Si vous souhaitez vous désabonner à tout moment
                                            de recevoir de futurs email, vous pouvez nous envoyer un courriel à</strong> <a href="mailto:contact@ptb.io">contact@ptb.io</a> et nous vous retirerons rapidement de <strong>TOUTES</strong> correspondance.</p>

                                </div>
                                <span id='ourCon'></span>
                                <p class='grayText'><strong>
                                        Nous contacter</strong></p>
                                <p>
                                    Si vous avez des questions concernant cette politique de confidentialité, vous pouvez
                                    contactez-nous en utilisant les informations ci-dessous.</p>
                                <p>Ptb.io</p>
                                <p>contact@ptb.io</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('components.footer')
    </div>


@endsection

@push('scripts')
    {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs(App::getLocale()) !!}

@endpush
