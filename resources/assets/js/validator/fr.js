import localeFr from 'vee-validate/dist/locale/fr';

export default Object.assign({}, localeFr,
    {
        attributes: {
            'first_name': 'le prénom',
            'last_name': 'le nom',
            'email': "l'adresse email",
            'password': "le mot de passe",
            'password_confirmation': 'la confirmation du mot de passe'

        },
        custom: {
            'password_confirmation': {
                confirmed: 'Les deux mots de passe ne correspondent pas.'
            }
        }
    }
);