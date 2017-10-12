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
            'booking_code': 'la référence de réservation',
            'price': 'le prix'
        },
        custom: {
            'password_confirmation': {
                confirmed: 'Les deux mots de passe ne correspondent pas.'
            }
        }
    }
);