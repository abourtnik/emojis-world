const typesense = require('../databases/typesense');

(async function(){
    await typesense.delete('collections/emojis')
    process.exit(0);
})();


