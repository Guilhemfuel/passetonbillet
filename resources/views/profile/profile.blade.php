@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="row" id="profile-home">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-lastar reverse">
                        <h4 class="card-title mb-0">Mon profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-lg-4 col-sm-12">
                                <img class="profile-picture mx-auto rounded-circle img-responsive"
                                     src="{{Auth::user()->picture}}" alt="profile_picture"/>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12">
                                <div class="align-middle">
                                    <h4 class="text-uppercase text-center">{{Auth::user()->full_name}}</h4>
                                    <h5 class="text-uppercase text-center">{{Auth::user()->birthdate}}</h5>
                                    <h5 class="text-uppercase text-center">{{Auth::user()->location}}</h5>
                                    <br>
                                    <h5 class="text-center">{{Auth::user()->phone}}</h5>
                                    <h5 class="text-center">{{Auth::user()->email}}</h5>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12">
                                <button class="btn btn-block btn-lastar-blue">Vérifier compte <i
                                            class="fa fa-check-circle text-warning" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="modalPasswordOpen=true">Changer le mot de passe
                                </button>
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="modalInfoOpen=true">Modifier les informations
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-stats">
                    <div class="card-header card-header-lastar reverse">
                        <h4 class="card-title mb-0">Statistiques</h4>
                    </div>
                    <div class="card-body">

                    </div>
                </div>

                <modal v-cloak :is-open="modalInfoOpen" @close-modal="modalInfoOpen=false" title="Modifier le profil">
                    <div class="modal-body">
                        <p>Pour corriger ou mettre à jour une information de votre profil, contactez un membre de l'équipe Lastar. Pour cela, cliquez sur le chat en bas à droite de votre écran, ou sur le bouton ci-dessous.</p>
                        <button onclick="$crisp.push(['do', 'chat:open'])" class="btn btn-block btn-lastar-blue">Contactez-nous!</button>
                    </div>
                </modal>

                <modal v-cloak :is-open="modalPasswordOpen" @close-modal="modalPasswordOpen=false" title="Modifier le mot de passe">
                    <div class="modal-body">
                        <form method="post">
                            Ancien Mot de passe
                            Nouveau mot de passe
                            Confirmer nouveau mot de passe
                            <button onclick="$crisp.push(['do', 'chat:open'])" class="btn btn-block btn-lastar-blue">Sauver le mot de passe</button>
                        </form>
                    </div>
                </modal>
            </div>
@endsection


@push('scripts')
    <script type="text/javascript">
        var profile = new Vue({
            el: '#profile-home',
            data: {
                modalInfoOpen: false,
                modalPasswordOpen: false
            }
        });
    </script>
@endpush


