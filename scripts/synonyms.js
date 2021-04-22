const fs = require('fs');
const cliProgress = require('cli-progress');

const typesense = require('../databases/typesense');

(async function(){

    let data = fs.readFileSync('../synonyms.json');
    let synonyms = JSON.parse(data);

    const bar = new cliProgress.SingleBar({}, cliProgress.Presets.shades_classic);

    bar.start(synonyms.length, 0);

    for (let i = 0 ; i < synonyms.length ; i ++) {

        let synonym = synonyms[i];

        // Create Typesense document emoji

        await typesense.put('collections/emojis/synonyms/' + synonym.name, {
            synonyms: synonym.synonyms,
        }).catch(e => console.log(e.response.data.message));

        bar.increment();
    }

    bar.stop();

    process.exit();

})();


