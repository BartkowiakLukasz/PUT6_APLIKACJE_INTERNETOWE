const rp = require('request-promise');

const jsdom = require('jsdom');
const { JSDOM } = jsdom;

const url = "https://donsorbero.com/sklep?query=&brand=&category=yerba-mate&tag=&fromPrice=0&toPrice=691&sort=latest&perPage=40&page=1";

const options = {
    uri: url,
    headers: {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept': 'application/json, text/plain, */*',
        'X-Requested-With': 'XMLHttpRequest'
    },
    json: true
};

rp(options)
    .then(function(daneZeSklepu) {
        console.log("got html");

        let products = daneZeSklepu.products.data;
        console.log("Found products:", products.length)
    })
    .catch(function(err) {
        console.log("connection failed", err.message);
    });
