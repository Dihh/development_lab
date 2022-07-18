var express = require('express');
var busboy = require('connect-busboy');
var path = require('path');
var FormData = require('form-data');
const fetch = require('node-fetch');
const { GoogleSpreadsheet } = require('google-spreadsheet')
const creds = require('./client_secret.json')
const ocrKey = require('./ocr-api.json')

var app = express();
app.use(busboy());
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
    res.send(`
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="nubank" >
        </br>
        </br>
        <input type="file" name="Inter" >
        </br>
        </br>
        <input type="file" name="Banco do Brasil" >
        </br>
        </br>
        <input type="file" name="Alimentação" >
        </br>
        </br>
        <input type="file" name="Refeição" >
        </br>
        </br>
        <input type="submit">
    </form>
</body>

</html>
    `)
})

var doc = new GoogleSpreadsheet('1Iyj02i8l7lXiRFe7bfcZKkXFldcbSVJ-psBZGN3PFA8');
doc.useServiceAccountAuth(creds).then(async () => {
    doc.loadInfo();
})

app.route('/upload')
    .post(function (req, res, next) {
        var fstream;
        req.pipe(req.busboy);

        const sheetData = {
            data: (new Date()).toISOString().split('T')[0].split('-').reverse().join('/'),
            Inter: '',
            nubank: '',
            "Banco do Brasil": '',
            Alimentação: '',
            Refeição: ''
        }

        req.busboy.on('file', async (fieldname, file) => {
            sheetData[fieldname] = await getValue(fieldname, file);
        });

        req.busboy.on('finish', async () => {
            setTimeout(async () => {
                const sheet = doc.sheetsByIndex[0];
                await sheet.addRow(sheetData);
                console.log('sheetData', sheetData)
                res.json(sheetData);
            }, 3000);
        })
    });

async function getValue(fieldname, file) {
    return new Promise((resolve, reject) => {
        var bufs = [];
        file.on('data', function (d) { bufs.push(d); });
        file.on('end', function () {
            var contents = 'data:image/jpeg;base64,' + Buffer.concat(bufs).toString('base64');

            var formData = new FormData()
            formData.append('language', 'eng')
            formData.append('isOverlayRequired', 'true')
            formData.append('base64Image', contents)
            fetch('https://api.ocr.space/parse/image', {
                method: 'post',
                body: formData,
                headers: ocrKey,
            }).then(data => data.json()).then(json => {
                const ParsedResults = json.ParsedResults.length ? json.ParsedResults[0] : null;
                if (ParsedResults) {
                    const Lines = ParsedResults.TextOverlay.Lines.length ? ParsedResults.TextOverlay.Lines[0] : null;
                    if (Lines) {
                        splitRS = Lines.LineText.split('R$ ')
                        splitRS2 = Lines.LineText.split('R$')
                        splitRS3 = Lines.LineText.split('RS ')
                        let data
                        if (splitRS.length > 1) {
                            data = Lines.LineText ? Lines.LineText.split('R$ ')[1] : '';
                        } else if (splitRS2.length > 1) {
                            data = Lines.LineText ? Lines.LineText.split('R$')[1] : '';
                        } if (splitRS3.length > 1) {
                            data = Lines.LineText ? Lines.LineText.split('RS ')[1] : '';
                        } else {
                            data = Lines.LineText
                        }
                        data = data.split('O').join(0);
                        resolve(data)
                    } else {
                        reject()
                    }
                } else {
                    reject()
                }
            });
        });
    })
}

var server = app.listen(process.env.PORT || '3030', function () {
    console.log('Listening on port %d', server.address().port);
});