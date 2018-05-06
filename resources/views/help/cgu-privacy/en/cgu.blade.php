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
                            <h2 class="text-center text-white">Terms of Service<br>Lastar.io</h2>
                            <p class="text-center text-white">
                                Last updated: March 10, 2018
                            </p>
                            <div class="container container-over-bg p-5 mt-3 text-justify">

                                <h4 class="mt-3 pb-3">ARTICLE 1. LEGAL INFORMATION
                                </h4>

                                <p>Under Article 6 of Law No. 2004-575 of 21 June 2004 on confidence in the digital
                                    economy, this article specifies the identity of the various parties involved in its
                                    implementation and monitoring.
                                </p>

                                <p>
                                    Lastar.io website is published by:
                                </p>

                                <p class="ml-5">
                                    Axel A. & Julien N.
                                    <br>E-mail address: contact@lastar.io

                                    The publishing directors of the site are:
                                    Axel A. & Julien N.

                                </p>

                                <p>
                                    Lastar.io site is hosted by:
                                </p>
                                <p class="ml-5">
                                    Heroku Inc., headquartered at 650 7th Street, San Francisco, CA <br>
                                    Phone number: +33 1 (877) 563-4311

                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 2. PRESENTATION OF THE SITE</h4>

                                <p>
                                    The Lastar.io site aims to:
                                </p>
                                <p class="ml-5">
                                    Connect users who want to buy or sell European train tickets between them. Tickets MUST be nominative under the name of the Lastar.io user.
                                </p>

                                <h4 class="mt-5 pb-3">ARTICLE 3. CONTACT
                                </h4>

                                <p>
                                    For any question or request for information about the site, or any report of illegal
                                    content or activities, the user can contact the editor at the following e-mail
                                    address: contact@lastar.io.
                                </p>

                                <h4 class="pt-1 pb-3">
                                    ARTICLE 4. ACCEPTANCE OF TERMS OF USE
                                </h4>

                                <p>
                                    Access and use of the site are subject to acceptance and compliance with these Terms
                                    of Use.
                                    <br><br>The publisher reserves the right to modify, at any time and without notice,
                                    the site
                                    and the services as well as the present TOU, in particular to adapt to the
                                    evolutions of the site by the provision of new functionalities or the deletion or
                                    the modification of existing features.
                                    <br><br>It is therefore advisable for the user to refer before any navigation to the
                                    latest
                                    version of the Terms, accessible at any time on the site. In case of disagreement
                                    with the TOU, no use of the site can be made by the user.

                                </p>


                                <h4 class="mt-5 pb-3">
                                    ARTICLE 5. ACCESS AND NAVIGATION
                                </h4>

                                <p>
                                    Access to the site and its use are reserved for persons aged at least 16 years old.
                                    The publisher will be entitled to request a justification of the age of the user, by
                                    any means.
                                    <br><br>The publisher implements the technical solutions at his disposal to allow
                                    access to the site 24 hours a day, 7 days a week. He may nevertheless at any time
                                    suspend, limit or interrupt access to the site or to certain pages of the site. the
                                    latter to make updates, changes to its content or any other action deemed necessary
                                    for the proper functioning of the site.
                                    <br><br>The connection and browsing on the site Lastar.io are worth full acceptance
                                    of these Terms of Use, whatever the technical means of access and terminals used.
                                    <br><br>These Terms apply, as necessary, any declination or extension of the site on
                                    social networks and / or community existing or future.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 6. SITE MANAGEMENT
                                </h4>

                                <p>
                                    For the good management of the site, the publisher can at any time:
                                    <br>
                                <ul>
                                    <li>suspend, interrupt or limit access to all or part of the site, reserve access to
                                        the site, or parts of the site, to a specific category of user;

                                    </li>
                                    <li>to delete any information that could disrupt its operation or that contravenes
                                        national or international laws or Netiquette rules;

                                    </li>
                                    <li>suspend the site in order to carry out updates.
                                    </li>
                                </ul>

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 7. SERVICES RESERVED FOR REGISTERED USERS
                                </h4>

                                <h5 class="pb-3">
                                    7.1 REGISTRATION
                                </h5>

                                <p>
                                    Access to certain services is conditioned by the registration of the user.
                                    <br><br>The registration and access to the services of the site are reserved
                                    exclusively for natural persons legally capable, having completed and validated the
                                    registration form available online on the website Lastar.io, as well as these Terms
                                    of Use.

                                    <br><br>When registering, the user agrees to provide accurate, truthful and
                                    up-to-date information about his person and his marital status. The user will also
                                    have to regularly check the data concerning him in order to preserve its accuracy.

                                    <br><br>The user must provide a valid e-mail address, on which the site will send a
                                    confirmation of his registration to his services. An e-mail address cannot be used
                                    multiple times to register for services.

                                    <br><br>Any communication made by Lastar.io and its partners is therefore deemed to
                                    have been received and read by the user. The latter therefore undertakes to
                                    regularly consult the messages received on this e-mail address and to respond within
                                    a reasonable time if necessary.

                                    <br><br>Only one registration for the services of the site is admitted by natural
                                    person.

                                    <br><br>The user is assigned an identifier allowing him to access a space whose
                                    access is reserved for him (hereinafter "Personal Area"), in addition to entering
                                    his password.

                                    <br><br>The username and password can be modified online by the user in his Personal
                                    Area. The password is personal and confidential, the user agrees not to communicate
                                    it to third parties.

                                    <br><br>Lastar.io reserves in any case the possibility of refusing an application
                                    for registration to the services in case of non-compliance by the User of the
                                    provisions of these Terms of Use.


                                </p>

                                <h5 class="mt-3 pb-3">
                                    7.2 DISINSCRIPTION
                                </h5>

                                <p>
                                    The regularly registered user may at any time request unsubscription by visiting the
                                    dedicated page in his Personal Area. Any unsubscription from the site will be
                                    effective immediately after the user has completed the form provided for this
                                    purpose.


                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 8. RESPONSIBILITIES
                                </h4>

                                <p>
                                    The publisher is only responsible for the content he has edited himself.
                                    The publisher is not responsible :
                                </p>
                                <ul>
                                    <li>
                                        in case of issues or technical, computer or compatibility problems of the site
                                        with any hardware or software;
                                    </li>
                                    <li> direct or indirect, material or immaterial, foreseeable or unforeseeable damage
                                        resulting from the use or difficulties of use of the site or its services;

                                    </li>
                                    <li> intrinsic characteristics of the Internet, particularly those relating to
                                        unreliability and lack of security of information circulating there;

                                    </li>
                                    <li> unlawful content or activities using his site without his having been duly
                                        informed within the meaning of Law No. 2004-575 of 21 June 2004 on Confidence in
                                        the Digital Economy and Law No. 2004- 801 of 6 August 2004 on the protection of
                                        individuals with regard to the processing of personal data;
                                    </li>
                                    <li> the sale of a fake European train ticket between the users preventing a buyer from
                                        taking the train indicated on the purchased ticket;

                                    </li>
                                    <li> the sale of a European train ticket in multiple copies between the users preventing a
                                        buyer from taking the train indicated on the purchased ticket;

                                    </li>
                                    <li> any legal problem involving the purchase and resale of European train tickets;

                                    </li>
                                    <li> any physical problems that may occur during the exchange of European train tickets
                                        between Lastar users;

                                    </li>
                                    <li> any financial problem including the non-receipt of the total or partial amount
                                        corresponding to the selling price of an European train ticket listed on Lastar.io that
                                        may occur during the exchange of European train tickets between users of Lastar.

                                    </li>
                                </ul>

                                <p>
                                    The publisher reminds users that the ONLY ONE UNIQUE role of the online platform
                                    Lastar.io is to CONNECT INDIVIDUALS WISHING TO BUY OR RESELL EUROPEAN TRAIN TICKETS UNDER
                                    THEIR NAME.
                                    LASTAR INC. IS NOT INVOLVED AND HAS NO RESPONSIBILITY IN ALL FINANCIAL TRANSACTIONS
                                    AND PHYSICAL AND VIRTUAL EXCHANGES AND PROBLEMS RELATED TO THE LATTERS AFTER TWO
                                    USERS OF THE PLATFORM HAVE BEEN CONNECTED TOGETHER THROUGH THE LASTAR.IO WEBSITE.
                                    <br><br>Furthermore, the site can not guarantee the accuracy, completeness, and
                                    timeliness of the information that is disseminated.
                                    <br><br>The user is responsible for:

                                </p>

                                <ul>
                                    <li>the protection of his equipment and data;

                                    </li>
                                    <li>the use he makes of the site or its services;
                                    </li>
                                    <li>if it does not respect the letter or the spirit of these Terms of Use.

                                    </li>
                                </ul>

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 9. HYPERTEXT LINKS
                                </h4>

                                <p>
                                    The site may contain hypertext links pointing to other websites on which Lastar.io
                                    does not exercise control. Despite the prior and regular verifications carried out
                                    by the publisher, it declines all responsibility for the content that can be found
                                    on these sites.

                                    <br><br>The publisher authorizes the setting up of hypertext links to any page or
                                    document of his site provided that the establishment of these links is not carried
                                    out for commercial or advertising purposes.

                                    <br><br>In addition, the prior information of the publisher of the site is necessary
                                    before setting up any hypertext link.

                                    <br><br>This authorization does not cover sites that disseminate information that is
                                    unlawful, violent, controversial, pornographic, xenophobic or that may affect the
                                    sensitivity of the greatest number.

                                    <br><br>Finally, Lastar.io reserves the right to delete at any time a hypertext link
                                    pointing to its site, if the site considers it not in accordance with its editorial
                                    policy.

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 10. COOKIES
                                </h4>

                                <p>
                                    The site may use "cookies" techniques to process traffic statistics and information,
                                    facilitate navigation and improve the service for the convenience of the user, who
                                    may oppose the use of cookies. registration of these "cookies" by configuring its
                                    browser software.
                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 11. PROPRIÉTÉ INTELLECTUELLE
                                </h4>

                                <p>
                                    The structure of the site but also the texts, graphics, images, photographs, sounds,
                                    videos and computer applications that compose it are the property of the publisher
                                    and are protected as such by the laws in force under the intellectual property.

                                    <br><br>Any representation, reproduction, adaptation or partial or total use of the
                                    contents, trademarks and services offered by the site, by any means whatsoever,
                                    without the prior express written permission of the publisher, is strictly
                                    prohibited and would be susceptible to constitute an infringement within the meaning
                                    of articles L. 335-2 and following of the Code of the intellectual property. With
                                    the exception of items expressly designated as royalty-free on the site.

                                    <br><br>Access to the site does not constitute recognition of a right and, in
                                    general, does not confer any intellectual property rights relating to an element of
                                    the site, which remain the exclusive property of the publisher.

                                    <br><br>It is forbidden for the user to enter data on the site that modifies or is
                                    likely to modify its content or appearance.

                                </p>

                                <h4 class="mt-5 pb-3">
                                    ARTICLE 12. APPLICABLE LAW AND COMPETENT JURISDICTION
                                </h4>

                                <p>
                                    These Terms of Use are governed by French law. In case of dispute and failing
                                    amicable agreement, the dispute will be brought before the French courts in
                                    accordance with the rules of jurisdiction in force.
                                </p>

                                <p class="text-center font-italic mt-5">
                                    The Lastar.io website wishes you an excellent navigation!
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
