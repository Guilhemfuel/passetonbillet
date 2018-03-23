@extends('layouts.app')

@section('content')

    <div class="cgu-page">

        <div class="section-header">
            <div class="first-section" style="background-image: url('{{secure_asset('img/bg/3.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{secure_asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo lastar">
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
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @else
                                <a class="nav-link" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div>
                            <h2 class="text-center text-white">CONDITIONS GÉNÉRALES D'UTILISATION DU
                                SITE<br>Lastar.io</h2>
                            <p class="text-center text-white">
                                Version en date du 10 Mars 2018
                            </p>
                            <div class="container container-over-bg p-5 mt-3 text-justify">

                                <h4 class="mt-3 pb-3">ARTICLE 1. INFORMATIONS LÉGALES</h4>

                                <p>En vertu de l'article 6 de la Loi n° 2004-575 du 21 juin 2004 pour la confiance dans
                                    l'économie numérique, il est précisé dans cet article l'identité des différents
                                    intervenants dans le cadre de sa réalisation et de son suivi.
                                </p>

                                <p>
                                    Le site Lastar.io est édité par :
                                </p>

                                <p class="ml-5">
                                    Axel Amer & Julien Nahum
                                    <br>Téléphone : +447507418244 & +44 7397 515743
                                    <br>Adresse e-mail : contact@lastar.io

                                    Les directeurs de publication du site sont :
                                    Axel Amer & Julien Nahum.

                                </p>

                                <p>
                                    Le site Lastar.io est hébergé par :
                                </p>
                                <p class="ml-5">
                                    Heroku Inc., dont le siège est situé 650 7th Street, San Francisco, CA <br>
                                    Numéro de téléphone : +33 1 (877) 563-4311

                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 2. PRÉSENTATION DU SITE</h4>

                                <p>
                                    Le site Lastar.io a pour objet :
                                </p>
                                <p class="ml-5">
                                    Mettre en relation des utilisateurs souhaitant acheter ou vendre des billets
                                    Eurostar entre eux. Les billets doivent IMPERATIVEMENT être achetés au préalablement
                                    sur eurostar.com, snap.eurostar.com ou sncf.com afin de pouvoir être postés sur
                                    Lastar.io. Les billets doivent IMPERATIVEMENT être nominatifs sous le nom de
                                    l'utilisateur Lastar.io.
                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 3. CONTACT
                                </h4>

                                <p>
                                    Pour toute question ou demande d'information concernant le site, ou tout signalement
                                    de contenu ou d'activités illicites, l'utilisateur peut contacter l'éditeur à
                                    l'adresse e-mail suivante: contact@lastar.io.
                                </p>

                                <h4 class="pt-1 pb-3">
                                    ARTICLE 4. ACCEPTATION DES CONDITIONS D'UTILISATION
                                </h4>

                                <p>
                                    L'accès et l'utilisation du site sont soumis à l'acceptation et au respect des
                                    présentes Conditions Générales d'Utilisation.
                                    <br><br>L'éditeur se réserve le droit de modifier, à tout moment et sans préavis, le
                                    site et des services ainsi que les présentes CGU, notamment pour s'adapter aux
                                    évolutions du site par la mise à disposition de nouvelles fonctionnalités ou la
                                    suppression ou la modification de fonctionnalités existantes.
                                    <br><br>Il est donc conseillé à l'utilisateur de se référer avant toute navigation à
                                    la dernière version des CGU, accessible à tout moment sur le site. En cas de
                                    désaccord avec les CGU, aucun usage du site ne saurait être effectué par
                                    l'utilisateur.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 4. ACCEPTATION DES CONDITIONS D'UTILISATION
                                </h4>

                                <p>
                                    L'accès et l'utilisation du site sont soumis à l'acceptation et au respect des
                                    présentes Conditions Générales d'Utilisation.
                                    <br><br>L'éditeur se réserve le droit de modifier, à tout moment et sans préavis, le
                                    site et des services ainsi que les présentes CGU, notamment pour s'adapter aux
                                    évolutions du site par la mise à disposition de nouvelles fonctionnalités ou la
                                    suppression ou la modification de fonctionnalités existantes.
                                    <br><br>Il est donc conseillé à l'utilisateur de se référer avant toute navigation à
                                    la dernière version des CGU, accessible à tout moment sur le site. En cas de
                                    désaccord avec les CGU, aucun usage du site ne saurait être effectué par
                                    l'utilisateur.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 5. ACCÈS ET NAVIGATION
                                </h4>

                                <p>
                                    L'accès au site et son utilisation sont réservés aux personnes âgées au minimum de
                                    16 ans. L'éditeur sera en droit de demander une justification de l'âge de
                                    l'utilisateur, et ce par tout moyen.
                                    <br><br>L'éditeur met en œuvre les solutions techniques à sa disposition pour
                                    permettre l'accès au site 24 heures sur 24, 7 jours sur 7. Il pourra néanmoins à
                                    tout moment suspendre, limiter ou interrompre l'accès au site ou à certaines pages
                                    de celui-ci afin de procéder à des mises à jours, des modifications de son contenu
                                    ou tout autre action jugée nécessaire au bon fonctionnement du site.
                                    <br><br>La connexion et la navigation sur le site Lastar.io valent acceptation sans
                                    réserve des présentes Conditions Générales d'Utilisation, quelques soient les moyens
                                    techniques d'accès et les terminaux utilisés.
                                    <br><br>Les présentes CGU s'appliquent, en tant que de besoin, à toute déclinaison
                                    ou extension du site sur les réseaux sociaux et/ou communautaires existants ou à
                                    venir.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 6. GESTION DU SITE
                                </h4>

                                <p>
                                    Pour la bonne gestion du site, l'éditeur pourra à tout moment :<br>
                                <ul>
                                    <li>suspendre, interrompre ou limiter l'accès à tout ou partie du site, réserver
                                        l'accès au site, ou à certaines parties du site, à une catégorie déterminée
                                        d'internaute ;
                                    </li>
                                    <li>supprimer toute information pouvant en perturber le fonctionnement ou entrant en
                                        contravention avec les lois nationales ou internationales, ou avec les règles de
                                        la Nétiquette ;
                                    </li>
                                    <li>suspendre le site afin de procéder à des mises à jour.</li>
                                </ul>

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 7. SERVICES RÉSERVÉS AUX UTILISATEURS INSCRITS
                                </h4>

                                <h5 class="pb-3">
                                    7.1 INSCRIPTION
                                </h5>

                                <p>
                                    L'accès à certains services est conditionné par l'inscription de l'utilisateur.
                                    <br><br>L'inscription et l'accès aux services du site sont réservés exclusivement
                                    aux personnes physiques capables juridiquement, ayant rempli et validé le formulaire
                                    d'inscription disponible en ligne sur le site Lastar.io, ainsi que les présentes
                                    Conditions Générales d'Utilisation.
                                    <br><br>Lors de son inscription, l'utilisateur s'engage à fournir des informations
                                    exactes, sincères et à jour sur sa personne et son état civil. L'utilisateur devra
                                    en outre procéder à une vérification régulière des données le concernant afin d'en
                                    conserver l'exactitude.
                                    <br><br>L'utilisateur doit ainsi fournir impérativement une adresse e-mail valide,
                                    sur laquelle le site lui adressera une confirmation de son inscription à ses
                                    services. Une adresse de messagerie électronique ne peut être utilisée plusieurs
                                    fois pour s'inscrire aux services.
                                    <br><br>Toute communication réalisée par Lastar.io et ses partenaires est en
                                    conséquence réputée avoir été réceptionnée et lue par l'utilisateur. Ce dernier
                                    s'engage donc à consulter régulièrement les messages reçus sur cette adresse e-mail
                                    et à répondre dans un délai raisonnable si cela est nécessaire.
                                    <br><br>Une seule inscription aux services du site est admise par personne physique.
                                    <br><br>L'utilisateur se voit attribuer un identifiant lui permettant d'accéder à un
                                    espace dont l'accès lui est réservé (ci-après "Espace personnel"), en complément de
                                    la saisie de son mot de passe.
                                    <br><br>L'identifiant et le mot de passe sont modifiables en ligne par l'utilisateur
                                    dans son Espace personnel. Le mot de passe est personnel et confidentiel,
                                    l'utilisateur s'engage ainsi à ne pas le communiquer à des tiers.
                                    <br><br>Lastar.io se réserve en tout état de cause la possibilité de refuser une
                                    demande d'inscription aux services en cas de non-respect par l'Utilisateur des
                                    dispositions des présentes Conditions Générales d'Utilisation.

                                </p>

                                <h5 class="mt-3 pb-3">
                                    7.2 DÉSINSCRIPTION
                                </h5>

                                <p>
                                    L'utilisateur régulièrement inscrit pourra à tout moment demander sa désinscription
                                    en se rendant sur la page dédiée dans son Espace personnel. Toute désinscription du
                                    site sera effective immédiatement après que l'utilisateur ait rempli le formulaire
                                    prévu à cet effet.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 8. RESPONSABILITÉS
                                </h4>

                                <p>
                                    L'éditeur n'est responsable que du contenu qu'il a lui-même édité.
                                    L'éditeur n'est pas responsable :
                                </p>
                                <ul>
                                    <li>
                                        en cas de problématiques ou défaillances techniques, informatiques ou de
                                        compatibilité
                                        du site avec un matériel ou logiciel quel qu'il soit ;
                                    </li>
                                    <li> des dommages directs ou indirects, matériels ou immatériels, prévisibles ou
                                        imprévisibles résultant de l'utilisation ou des difficultés d'utilisation du
                                        site ou de
                                        ses services ;
                                    </li>
                                    <li> des caractéristiques intrinsèques de l'Internet, notamment celles relatives au
                                        manque
                                        de fiabilité et au défaut de sécurisation des informations y circulant ;
                                    </li>
                                    <li> des contenus ou activités illicites utilisant son site et ce, sans qu'il en ait
                                        pris
                                        dûment connaissance au sens de la Loi n° 2004-575 du 21 juin 2004 pour la
                                        confiance dans
                                        l'économie numérique et la Loi n°2004-801 du 6 août 2004 relative à la
                                        protection des
                                        personnes physiques à l'égard de traitement de données à caractère personnel;
                                    </li>
                                    <li> de la vente d’un faux billet Eurostar entre les utilisateurs empêchant un
                                        acheteur de
                                        prendre le train indiqué sur le billet acheté ;
                                    </li>
                                    <li> de la vente d’un billet Eurostar en plusieurs exemplaires entre les
                                        utilisateurs
                                        empêchant un acheteur de prendre le train indiqué sur le billet acheté ;
                                    </li>
                                    <li> de tout problème légal impliquant l’achat et la revente de billets Eurostar ;
                                    </li>
                                    <li> de tout problème physique pouvant survenir lors de l’échange de billets
                                        Eurostar entre
                                        les utilisateurs Lastar ;
                                    </li>
                                    <li> de tout problème financiers incluant la non réception de la somme totale ou
                                        partiale
                                        correspondant au prix de vente d’un billet Eurostar listé sur Lastar.io pouvant
                                        survenir
                                        lors de l’échange de billets Eurostar entre les utilisateurs de Lastar.
                                    </li>
                                </ul>

                                <p>
                                    L'éditeur rappel aux utilisateurs que le SEUL est UNIQUE rôle de la plateforme en
                                    ligne
                                    Lastar.io est de METTRE EN RELATIONS DES INDIVIDUS SOUHAITANT ACHETER OU REVENDRE
                                    DES
                                    BILLETS EUROSTAR À LEUR NOM, ACHETÉS AU PRÉALABLE SUR EUROSTAR.COM, SNAPEUROSTAR.COM
                                    OU
                                    SNCF.COM. EN AUCUN CAS LASTAR INC. N’EST IMPLIQUÉE ET NE POSSÈDE AUCUNE
                                    REPONSABILITÉ
                                    DANS TOUTES LES TRANSACTIONS FINANCIÈRES ET ÉCHANGES PHYSIQUES ET VIRTUELS AINSI QUE
                                    LES
                                    PROBLÈMES LIÉS À CES DERNIERS APRÈS QUE DEUX UTILISATEURS DE LA PLATEFORME N’AIENT
                                    ÉTÉ
                                    MIS EN RELATIONS À TRAVERS LE SITE LASTAR.IO.
                                    Par ailleurs, le site ne saurait garantir l'exactitude, la complétude, et
                                    l'actualité
                                    des informations qui y sont diffusées.
                                    <br><br>
                                    L'utilisateur est responsable :
                                </p>

                                <ul>
                                    <li>de la protection de son matériel et de ses données ;
                                    </li>
                                    <li>de l'utilisation qu'il fait du site ou de ses services ;
                                    </li>
                                    <li>s'il ne respecte ni la lettre, ni l'esprit des présentes CGU.
                                    </li>
                                </ul>

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 9. LIENS HYPERTEXTES
                                </h4>

                                <p>
                                    Le site peut contenir des liens hypertextes pointant vers d'autres sites internet
                                    sur lesquels Lastar.io n'exerce pas de contrôle. Malgré les vérifications préalables
                                    et régulières réalisés par l'éditeur, celui-ci décline tout responsabilité quant aux
                                    contenus qu'il est possible de trouver sur ces sites.
                                    <br><br>L'éditeur autorise la mise en place de liens hypertextes vers toute page ou
                                    document de son site sous réserve que la mise en place de ces liens ne soit pas
                                    réalisée à des fins commerciales ou publicitaires.
                                    <br><br>En outre, l'information préalable de l'éditeur du site est nécessaire avant
                                    toute mise en place de lien hypertexte.
                                    <br><br>Sont exclus de cette autorisation les sites diffusant des informations à
                                    caractère illicite, violent, polémique, pornographique, xénophobe ou pouvant porter
                                    atteinte à la sensibilité du plus grand nombre.
                                    <br><br>Enfin, Lastar.io se réserve le droit de faire supprimer à tout moment un
                                    lien hypertexte pointant vers son site, si le site l'estime non conforme à sa
                                    politique éditoriale.

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 10. COOKIES
                                </h4>

                                <p>
                                    Le site a éventuellement recours aux techniques de "cookies" lui permettant de
                                    traiter des statistiques et des informations sur le trafic, de faciliter la
                                    navigation et d'améliorer le service pour le confort de l'utilisateur, lequel peut
                                    s'opposer à l'enregistrement de ces "cookies" en configurant son logiciel de
                                    navigation.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 11. PROPRIÉTÉ INTELLECTUELLE
                                </h4>

                                <p>
                                    La structuration du site mais aussi les textes, graphiques, images, photographies,
                                    sons, vidéos et applications informatiques qui le composent sont la propriété de
                                    l'éditeur et sont protégés comme tels par les lois en vigueur au titre de la
                                    propriété intellectuelle.
                                    <br><br>Toute représentation, reproduction, adaptation ou exploitation partielle ou totale
                                    des contenus, marques déposées et services proposés par le site, par quelque procédé
                                    que ce soit, sans l'autorisation préalable, expresse et écrite de l'éditeur, est
                                    strictement interdite et serait susceptible de constituer une contrefaçon au sens
                                    des articles L. 335-2 et suivants du Code de la propriété intellectuelle. Et ce, à
                                    l'exception des éléments expressément désignés comme libres de droits sur le site.
                                    <br><br>L'accès au site ne vaut pas reconnaissance d'un droit et, de manière générale, ne
                                    confère aucun droit de propriété intellectuelle relatif à un élément du site,
                                    lesquels restent la propriété exclusive de l'éditeur.
                                    <br><br>Il est interdit à l'utilisateur d'introduire des données sur le site qui
                                    modifieraient ou qui seraient susceptibles d'en modifier le contenu ou l'apparence.

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 12. LOI APPLICABLE ET JURIDICTION COMPÉTENTE
                                </h4>

                                <p>
                                    Les présentes Conditions Générales d'Utilisation sont régies par la loi française. En cas de différend et à défaut d'accord amiable, le litige sera porté devant les tribunaux français conformément aux règles de compétence en vigueur.
                                </p>

                                <p class="text-center font-italic mt-5">
                                    Le site Lastar.io vous souhaite une excellente navigation !
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @include('components.footer')
        </div>

    </div>

@endsection

@push('scripts')
    {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs(App::getLocale()) !!}

@endpush
