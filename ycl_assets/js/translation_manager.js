class TranslationManager {
    constructor() {
        // this.arrData = arrData;
    //     this.userLanguage = userLanguage;
    }

    static setUserLanguage(userLanguage) {
        TranslationManager.userLanguage = userLanguage;
    }

    static setArrData(arrData) {
        TranslationManager.arrData = arrData;
    }

   

    translate(key) {
        try {
            const translation = TranslationManager.arrData.find((item) => item.english_text === key);
            if (translation) {
                let language = TranslationManager.userLanguage + '_text';
                return translation[language];
            }
            return key;
        } catch (error) {
            console.log("TranslationManager: " + error);            
        }
    }

    static staticTranslate(key) {
        try {
            const translation = TranslationManager.arrData.find((item) => item.english_text === key);
            if (translation) {
                let language = TranslationManager.userLanguage + '_text';
                return translation[language];
            }
            return key;
        } catch (error) {
            console.log("TranslationManager: " + error);            
        }
    }

}

