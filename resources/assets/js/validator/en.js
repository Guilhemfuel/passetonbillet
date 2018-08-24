import localEn from 'vee-validate/dist/locale/en';

// This is the dictionary used by vee-validate.
// Language is english.

export default Object.assign({}, localEn,
    {
        attributes: {
            'booking code': 'booking code',
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
            'booking_code': {
                required: 'The Eurostar booking code is required.',
                max: 'The Eurostar booking code should be 6 characters long.',
                min: 'The Eurostar booking code should be 6 characters long.'
            }
        }
    }
);