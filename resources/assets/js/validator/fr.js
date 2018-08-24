import localeFr from 'vee-validate/dist/locale/fr';

// This is the dictionary used by vee-validate.
// Language is french.

export default Object.assign({}, localeFr,
    {
        attributes: {
            'first_name': 'le prénom',
            'last_name': 'le nom',
            'email': "l'adresse email",
            'birthdate': "la date de naissance",
            'gender': 'le sexe',
            'location': 'la position',
            'phone' : 'le numéro de téléphone',
            'password': "le mot de passe",
            'password_confirmation': 'la confirmation du mot de passe',
            'old_password': 'le mot de passe actuel',

            'booking_code': 'référence de réservation',
            'price': 'le prix',
            'travel_date': 'la date de voyage',
            'train_number': 'le numéro de train',
            'departure_station': 'la gare de départ',
            'arrival_station': 'la gare d\'arrivée',
            'departure_time': "l'heure de départ",
            'arrival_time': "l'heure d'arrivée",
            'company': "l'agence ferroviaire",
            'flexibility': "le tarif",
            'classe': "la classe",
            'currency': "la devise",
            'bought_price': "le prix d'achat",
        },
        custom: {
            'password_confirmation': {
                confirmed: 'Les deux mots de passe ne correspondent pas.'
            }
        }
    }
);