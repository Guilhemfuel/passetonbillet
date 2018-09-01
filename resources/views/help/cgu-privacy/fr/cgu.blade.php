@extends('layouts.app')

@section('content')

    <div class="cgu-page">

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
                            <h2 class="text-center text-white">CONDITIONS GÉNÉRALES D'UTILISATION DE WWW.PASSETONBILLET.FR</h2>
                            <p class="text-center text-white">
                                Version actuelle publiée le 01/09/2018 <br>
                                Version actuelle entrant en vigueur le 01/09/2018
                            </p>
                            <div class="container container-over-bg p-5 mt-3 text-justify">
                                <p> Le présent site internet passetonbillet.fr est édité par CB INNOVATION, société par actions simplifiée, au capital de 27 500 euros, immatriculée au Registre du Commerce et des Sociétés de Lyon, sous le numéro RCS 513 007 880, dont le siège est situé 27 route de limonest, 69 450, Saint Cyr au mont d’or.</p>

                                <br>

                                <h4 class="mt-3 pb-3">PREAMBULE</h4>

                                <p>CB INNOVATION a développé une Plateforme en ligne sur le Site accessible à l’adresse www.passetonbillet.fr.
                                    Cette Plateforme est destinée à proposer aux Utilisateurs, un service de mise de recherche et de publication de billets d’occasion pour le train.
                                    Nous vous remercions de lire attentivement les présentes CGU car elles contiennent des informations importantes concernant les droits et obligations des Utilisateurs. Elles incluent différentes limitations et exclusions, ainsi que des obligations relatives au respect des lois et réglementations applicables.
                                    Sauf conditions particulières relatives à un service ou à une offre, tout nouveau service ou modification de service en place et/ou produit par la société CB INNOVATION sera soumis aux présentes Conditions d'Utilisation.
                                </p>

                                <br>

                                <h4 class="mt-3 pb-3">ACCEPTATION DES CGU</h4>

                                <h5 class="mt-3 pb-3">Acceptation</h5>
                                <p>L’Utilisateur ne peut bénéficier des Services qui lui sont proposés sur la Plateforme que sous réserve de l’acceptation des présentes CGU. L’Utilisateur ne peut utiliser le Service sans avoir préalablement pris connaissance et accepté les CGU lors de son inscription sur la Plateforme.
                                    L’acceptation des présentes CGU sous forme d’une « case à cocher » constitue la preuve que l’Utilisateur a pris connaissance via le Site desdites dispositions et vaut acceptation des présentes CGU.
                                    Les présentes CGU sont disponibles et accessibles en ligne via le Site.
                                    L’Utilisateur déclare avoir obtenu de la part de PasseTonBillet  toutes les informations nécessaires quant aux Services proposés et adhérer sans réserve aux présentes CGU.
                                    L’Utilisateur dispose de la faculté de sauvegarder et d’imprimer les présentes CGU en utilisant les fonctionnalités standards de son navigateur ou de son ordinateur.
                                </p>

                                <h5 class="mt-3 pb-3">Opposabilité</h5>
                                <p>Les présentes CGU entrent en vigueur à la date de leur mise en ligne et sont opposables dès leur acceptation par l’Utilisateur, lors de son inscription à l’Espace Membre.
                                    Les présentes CGU sont opposables pendant toute la durée d’utilisation des Services et jusqu’à ce que de nouvelles CGU les remplacent.
                                    Les CGU figurant en ligne sur la Plateforme prévalent sur toute version imprimée de date antérieure.
                                    Les présentes CGU annulent et remplacent toute version antérieure.
                                    L’Utilisateur peut à tout moment renoncer à utiliser les Services et la Plateforme mais reste engagé sur toute utilisation antérieure.
                                </p>

                                <h5 class="mt-3 pb-3">Modification</h5>
                                <p>PasseTonBillet se réserve le droit, à sa seule discrétion, à tout moment et sans préavis, d'adapter ou de modifier les présentes CGU. Les modifications des présentes CGU seront notifiées aux Utilisateurs par le biais d’une fenêtre « pop in ». Si l’Utilisateur est en désaccord avec cette nouvelle version des CGU notifiée, il pourra librement cesser l’utilisation des Services.
                                    La nouvelle version des CGU sera publiée sur le Site.
                                    PasseTonBillet  informera chaque Utilisateur par courrier électronique à l’adresse renseignée sur le Compte Membre de toute modification des présentes CGU au plus tôt 30 (trente) jours avant leur entrée en vigueur.
                                    L’Utilisateur pourra émettre des observations à la nouvelle version des CGU dans les 30 (trente) jours suivant la réception de la notification des modifications des CGU. Passé ce délai, les nouvelles CGU seront réputées avoir été acceptées par l’Utilisateur.
                                    Lorsqu’un Utilisateur n’accepte pas les nouvelles CGU, il devra immédiatement arrêter d’utiliser le Site.
                                    En tout état de cause, à défaut d’observations, les nouvelles CGU seront réputées acceptées par l’Utilisateur qui, au moment de la prochaine location, acceptera expressément les CGU par le biais d’une case à cocher.
                                </p>

                                <br>

                                <h4 class="mt-3 pb-3">ARTICLE 1. OBJET</h4>

                                <p>Passetonbillet.fr est un site qui propose un certain nombre de services d’hébergement et de diffusion d’annonces de revente de billets et de mise en relation destinées aux particuliers. Le présent document a pour objet de déterminer les conditions générales d’utilisation du site internet « passetonbillet.fr». (Ci-après désignés les « Conditions d’Utilisation »). L’utilisateur désigne toute personne qui accède au Site PasseTonBillet (ci-après designé « l’Utilisateur ») Le site internet ci-après « Site » désigne le site accessible à l’adresse http://www.passetonbillet.fr. Tout Utilisateur ne respectant pas les dispositions prevues par les présentes Conditions d'Utilisation peut se voir retirer immédiatement l'accès aux services du Site, sans indemnité ni préavis. L’utilisation du site Internet « passetonbillet.fr » et des services qui y sont proposés suppose l’acceptation expresse, pleine et entière par l’utilisateur des présentes Conditions d’Utilisation. Les Conditions d’Utilisation pourront être révisées et mises à jour à tout moment, sans avertissement préalable. L’utilisateur est invité à les consulter à chacune de ses connexions au Site PasseTonBillet.
                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 2. UTILISATION ET INSCRIPTION A PASSETONBILLET</h4>

                                <p>
                                    L’accès à certaines fonctionnalités nécessite la création d’un compte. Vous garantissez que les données que vous nous communiquez sont exactes et conformes à la réalité. Après votre inscription vous disposez d’un identifiant et d’un mot de passe personnel et confidentiel. En aucun cas, vous ne devez divulguer ses informations, garantissant la confidentialité de votre navigation. PasseTonBillet ne saurait être responsable de la perte de ces éléments d’identification. Vous êtes le seul responsable de l’utilisation frauduleuse ou non par des tiers de vos identifiants et mots de passe. L’utilisateur est informé qu’il demeure entièrement responsable du respect du caractère confidentiel des mots de passe associés à tout compte lui permettant d’avoir accès à PasseTonBillet. Toute inscription jugée mauvaise pourra être supprimée par PasseTonBillet sans avoir à prévenir l‘Utilisateur inscrits au préalable. Pour s’inscrire, tout Utilisateur doit être majeur ou mineur émancipé de 18 ans au minimum ou alors utiliser le Site sous la stricte responsabilité d’un majeur surveillant la navigation de celui-ci.
                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 3. ANNONCES, CONDITIONS DE DIFFUSION ET TRANSACTIONS</h4>

                                <p>
                                    L'annonceur reconnaît être l'auteur unique et exclusif du texte de l'annonce. A défaut, il déclare disposer de tous les droits et autorisations nécessaires à la parution de l'annonce. PasseTonBillet est un intermédiaire technique au sens de l’article 6.1.2 de la loi pour la confiance en l’économie numérique dit « LCEN » du 21 juin 2004 et permet l’hébergement et la diffusion d’Annonces sur le site qu’elle édite et n'intervient qu'en cette qualité entre l’Utilisateur et les Annonceurs. L'annonce est diffusée sous la responsabilité exclusive de l'annonceur et PasseTonBillet n’intervient aucunement dans la rédaction et la publication des annonces. Les annonces doivent porter exclusivement sur des billets valables et authentiques et ne doivent pas indiquer de mentions fausses ou trompeuses. Tout utilisateur qui utilise le service de mise en ligne d’annonces de revente de billets certifie que l'annonce est conforme à l'ensemble des dispositions légales et réglementaires en vigueur et respecte les droits des tiers. Les annonces doivent se conformer à l’intégralité du droit en vigueur en France, et en particulier à la loi du 27 juin 1919, relative à la répression du trafic des billets de théâtre, selon laquelle la revente de billets bénéficiant de subventions publiques n'est autorisée que si le prix de revente n'excède pas le prix qui figure sur ces billets. Ainsi, il est rappelé à tous les utilisateurs du site, que le fait de vendre ou de céder des billets a un prix supérieur à la valeur faciale du billet est constitutif d’une infraction et d’une violation de la loi et des conditions d’utilisation.
                                </p>

                                <h5 class="mt-3 pb-3">Diffusion des annonces</h5>
                                <p>
                                    Il appartient au seul Utilisateur souhaitant vendre ou acheter un billet de se renseigner auprès de l'émetteur du billet pour connaître l'ensemble des conditions de transférabilité en vigueur. Il est rappelé qu’en toute circonstance, la cession des billets se fait aux risques et périls du cédant et du cessionnaire.
                                    CB INNOVATION décline, dans la limite de ce qui est autorisé par les dispositions légales d’ordre public, toute responsabilité quant aux Contenus Utilisateurs, à la licéité des articles proposés à la vente ou aux conditions de vente elles mêmes.
                                    Par conséquent, CB INNOVATION ne pourra, être tenu responsable directement ou indirectement en cas d’insatisfaction ou de préjudice subi par le vendeur ou l'acheteur d’un billet, et ce à quelque titre que ce soit.

                                <p> Pour publier une annonce sur le Site, l'Utilisateur s'engage à s'être préalablement assuré que le billet mis en vente respecte les conditions de la revente de billets de transports ferroviaires, en particulier les éléments suivants :</p>
                                <li>il est interdit de vendre un billet à un prix supérieur à la valeur faciale du  billet acheté </li>
                                <li>les informations présente dans une annonce publiées par les Utilisateurs doivent strictement correspondre à celles figurant sur le billet mise en vente par l’Utilisateur </li>
                                <li>la vente de billes doit avoir lieu entre particuliers et doit respecter toute autre condition générale ou particulière concernant la cession du billet.</li>
                                </p>

                                <p> Les utilisateurs vendeurs s’engagent à:
                                </p>
                                <li>ne pas revendre ou tenter de revendre les 'e-billet/m-billet SNCF ou les Confirmation e-billet SNCF/Mémo e-billet sous forme de billet "classique" qui sont nominatifs et incessibles dès leur achat. Dans le cas où un acheteur aurait, sans le savoir racheté un e-billet SNCF, une confirmation e-billet SNCF, un mémo e-billet SNCF il devra lui être remboursé par le vendeur.
                                </li>
                                <li>avertir les acheteurs des risques encourus à voyager avec des billets Eurostar, Thalys Ticketless, IZY Thalys qui peuvent faire l'objet de contrôle d'identité car ils sont nominatifs et incessibles.</li>
                                <li>
                                    rembourser l'acheteur du prix qu'ils auront reçu pour leur billet en cas de contrôle ayant obligé l'acheteur à annuler son voyage ou à racheter un billet au prix fort.
                                </li>
                                <li>
                                    reporter exactement et complètement les données indiquées sur le billet ou la commande du billet qu'ils mettent en vente (trajet, date, heure, prix payé, conditions d'utilisation, ...)
                                </li>
                                <li>
                                    ne pas céder un billet à un prix plus élevé que celui indiqué sur ce même billet.
                                </li>
                                <br>
                                <p>Les informations données par le vendeur le sont sous sa seule responsabilité et le site se réserve la possibilité de les modifier ou de les retirer de la vente, voire de ne pas mettre en vente le billet, si elles ne sont pas conformes à la charte,
                                </p>

                                <li>
                                    faire parvenir le plus rapidement possible le billet cédé à son destinataire dès lors qu’ils en ont reçu le paiement, suivant les modalités d’échange convenues entre les parties,
                                </li>
                                <li>
                                    ne pas utiliser les numéros de téléphone et les e-mails des acheteurs pour un autre usage que celui prévu par l’utilisation du site,
                                </li>
                                <li>
                                    retirer de la vente les billets qu’ils y ont déposés dès qu’ils se sont engagés à les vendre à un acheteur
                                </li>
                                <li>
                                    ne pas revendre aux acheteurs les ayant contactés par l'intermédiaire du site, des billets qui n'auraient pas fait l'objet d'un dépôt sur le site. Dans ce cas le site ne peut en aucune manière être tenu pour responsable de la validité de ces billets qu'il n'est pas en mesure de contrôler.
                                </li>

                                <br>

                                <h5>Modalités d'échange et transaction
                                </h5>

                                <li>
                                    elles sont à la convenance des parties. Elle se déroule directement entre le cédant et le cessionnaire. PasseTonBillet n'intervient pas dans la transaction, de même qu’elle n’agit pas en tant qu’intermédiaire.
                                </li>
                                <li>
                                    dans le cas d'échange par courrier, le site laisse le vendeur et l'acheteur libres d'utiliser la procédure qui leur convient.
                                </li>

                                <p>Conseils aux acheteurs:
                                </p>

                                <li>
                                    refusez de payer plus cher que le prix indiqué sur l'annonce et sur le billet,
                                </li>
                                <li>
                                    n'hésitez pas à avertir le modérateur du site si le vendeur veut vous faire payer plus cher que le prix payé indiqué sur le billet
                                </li>
                                <li>
                                    dans le cas d'un paiement avant envoi du billet, veillez à obtenir l'identité précise du vendeur (nom, prénom, adresse, téléphone, e-mail) et évitez les systèmes de paiement "anonymes" type "mandat cash" ou WESTERN UNION par ex.)
                                </li>

                                <p>Soyez très prudents lorsqu'il s'agit de billets imprimés Ouigo, Izy Thalys, Thello ou Eurostar car, même si le vendeur vous donne la référence de dossier vous permettant de créer et d'imprimer votre billet, il peut l'utiliser à votre insu pour échanger/modifier le billet, voir le revendre à plusieurs personne et faire en sorte que celui que vous avez en main devienne invalide.
                                </p>

                                <p>Nous avons constaté des escroqueries avec les billets Eurostar Paris-Londres ou Londres-Paris "imprimé" et nous déconseillons fortement de les racheter sans s'assurer de l'identité du vendeur.
                                </p>

                                <h5>Limitation de responsabilité
                                </h5>

                                <p>PasseTonBillet ne sera tenu en aucun cas à réparation, pécuniaire ou en nature, du fait d'erreurs ou d'omissions dans la composition ou la traduction d'une annonce, ou de défaut de parution de quelque nature que ce soit. De tels événements ne pourront en aucun cas ouvrir droit à une indemnisation sous quelque forme que ce soit. Comme rappelé, PasseTonBillet agit comme hébergeur d’annonces de vente de billets et ne peut être poursuivi sur le contenu des échanges, ni sur les suites qui leur seraient éventuellement données, sous quelque forme que ce soit. La responsabilité de PasseTonBillet en tant qu’intermédiaire technique ne peut être engagée qu’après avoir été notifié du caractère illicite du contenu diffusé sur le site. C’est ce qui conduira PasseTonBillet, sur simple notification faite dans les termes de l’article 6.I-5 de cette loi à propos des contenus litigieux et qui sont donc soit prohibés, soit portant atteinte aux droits de la personne et de la propriété intellectuelle, à procéder de son seul chef et par autorité au retrait des annonces correspondantes. PasseTonBillet ne peut être tenu responsable d'aucun préjudice subi par un Utilisateur dans le cadre d'une utilisation anormale des services de PasseTonBillet.
                                </p>

                                    <h4 class="pt-1 pb-3">
                                        ARTICLE 4. EXCLUSION DE GARANTIES
                                </h4>

                                <p>
                                    Le site passetonbillet.fr ne saurait garantir les éléments suivants:
                                </p>
                                <li>
                                    Que l'utilisation des services sera ininterrompue, rapide, sécurisée ou exempte d'erreurs.
                                </li>
                                <li>
                                    Que toute information que vous obtiendrez suite à l'utilisation du site PasseTonBillet sera exacte ou fiable.
                                </li>
                                <li>
                                    Que l’utilisation ou le résultat de l’utilisation du site PasseTonBillet sera correct, exact, opportun ou autrement fiable.
                                </li>
                                <p>Aucune garantie, condition ou autre stipulation y compris toute garantie implicite concernant la qualité satisfaisante, la convenance à un usage particulier ou la conformité à la description donnée ne s'applique à PasseTonBillet.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 5. PROPRIETE INTELLECTUELLE
                                </h4>

                                <p>
                                    L'ensemble des éléments constituant le Site (Modules, charte graphique, application, textes, graphismes, logiciels, photographies, images, vidéos, sons, plans, noms, logos, créations et œuvres protégeables diverses, bases de données, etc...) ainsi que le Site lui-même, relèvent des législations françaises et internationales sur le droit d'auteur et sur les droits voisins du droit d'auteur (notamment les articles L122-4 et L122-5. du Code de la Propriété Intellectuelle). Toute utilisation non expressément et préalablement autorisée d'éléments du Site par PasseTonBillet est constitutif d’une violation de ses droits de propriété intellectuels et constitue une contrefaçon. Elle peut aussi entraîner une violation des droits à l'image, droits des personnes ou de tous autres droits et réglementations en vigueur.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 6. PROTECTION DES DONNÉES PERSONNELLES
                                </h4>

                                <p>
                                    Conformément à la loi n°78-17 du 6 janvier 1978, dite « Informatique et libertés », PasseTonBillet a fait l'objet d'une déclaration auprès de la Commission Nationale de l'Informatique et des Libertés (C.N.I.L) sous le numéro: 1371661. Conformément à l'article 27 de la loi n°78-17 du 6 janvier 1978, vous disposez à tout moment d'un droit d'accès et de rectification des données vous concernant. Pour exercer ces droits, les Utilisateurs du Site Internet PasseTonBillet sont invités à adresser un email à l’adresse : contact@passetonbillet.fr
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 7. NULLITE
                                </h4>

                                <p>
                                    Si une ou plusieurs dispositions des présentes Conditions d’Utilisation sont tenues pour non valides ou déclarées comme telles en application d'une loi, d'un règlement ou à la suite d'une décision devenue définitive d'une juridiction compétente, les autres stipulations des présentes Conditions d’Utilisation garderont toute leur force et leur portée. Dans cette hypothèse PasseTonBillet s’engage à supprimer et remplacer immédiatement ledit article par une autre clause juridiquement valide.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 8. TITRE
                                </h4>

                                <p>
                                    En cas de difficulté d'interprétation entre le titre et le chapitre de l’un quelconque des articles et l'une quelconque des clauses, les titres seront réputés non-écrits.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 9. DROIT APPLICABLE – ATTRIBUTION DE JURIDICTION
                                </h4>

                                <p>
                                    Les présentes Conditions d'Utilisation sont régies, interprétées et appliquées par le droit français. La langue d'interprétation est la langue française en cas de contestation sur la signification d'un terme ou d'une disposition des présentes Conditions d'Utilisation. Tout désaccord ou litige n'ayant pu trouver une issue transactionnelle sera porté devant les tribunaux compétents. PasseTonBillet n'est pas compétent pour régler les litiges qui pourraient naître entre les Utilisateurs.
                                </p>

                                <br>
                                <br>

                                <h5>Informations légales</h5>

                                <br>
                                <p>Nom de domaine: passetonbillet.fr</p>
                                <br>
                                <p>Editeur: CB INNOVATION SAS</p>
                                <br>
                                <p>Contact: contact(at)passetonbillet.fr</p>
                                <br>
                                <p>Hébergeur:</p>
                                <p>SAS OVH - https://www.ovh.com</p>
                                <p>2 rue Kellermann</p>
                                <p>BP 80157</p>
                                <p>59100 Roubaix</p>


                                <p class="text-center font-italic mt-5">
                                    L'équipe PasseTonBillet.fr vous souhaite une excellente navigation !
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
