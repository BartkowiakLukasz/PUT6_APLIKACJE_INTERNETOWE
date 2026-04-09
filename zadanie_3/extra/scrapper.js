const rp = require('request-promise');
const fs = require('fs');

async function fetchAllProducts() {
    let allProducts = [];
    let currentPage = 1;
    let isFinished = false;

    console.log("Fetching data...");

    while (!isFinished) {
        console.log(`-> Fetching page ${currentPage}...`);

        let url = `https://donsorbero.com/sklep?query=&brand=&category=yerba-mate&tag=&fromPrice=0&toPrice=691&sort=latest&perPage=40&page=${currentPage}`;

        let options = {
            uri: url,
            headers: {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept': 'application/json, text/plain, */*',
                'X-Requested-With': 'XMLHttpRequest'
            },
            json: true
        };

        try {
            let responseData = await rp(options);
            let products = responseData.products.data;
            let lastPage = responseData.products.last_page;

            products.forEach(function (product) {
                let name = product.name;
                let price = parseFloat(product.price_brutto.amount);

                let nameLower = name.toLowerCase();
                
                if (nameLower.includes('saszetki') || nameLower.includes('szt') || nameLower.includes('mix') || nameLower.includes('start')) {
                    return;
                }

                let weightInGrams = 500;

                let matchMulti = name.match(/(\d+)\s*[xX]\s*(\d+(?:[.,]\d+)?)\s*(k?g)/i);
                let matchKg = name.match(/(\d+(?:[.,]\d+)?)\s*kg/i);
                let matchG = name.match(/(\d+(?:[.,]\d+)?)\s*g/i);

                if (matchMulti) {
                    let quantity = parseFloat(matchMulti[1]);
                    let packageWeight = parseFloat(matchMulti[2].replace(',', '.'));
                    let unit = matchMulti[3].toLowerCase();

                    weightInGrams = quantity * packageWeight;
                    if (unit === 'kg') weightInGrams *= 1000;
                }
                else if (matchKg) {
                    weightInGrams = parseFloat(matchKg[1].replace(',', '.')) * 1000;
                }
                else if (matchG) {
                    weightInGrams = parseFloat(matchG[1].replace(',', '.'));
                }

                let priceFor100g = (price / weightInGrams) * 100;

                allProducts.push({
                    name: name,
                    price: price.toFixed(2) + " PLN",
                    priceFor100g: parseFloat(priceFor100g.toFixed(2))
                });
            });

            if (currentPage >= lastPage) {
                isFinished = true;
            }
            else {
                currentPage++;
            }
        }
        catch (err) {
            console.error(`Failed to fetch page ${currentPage}:`, err.message);
            isFinished = true;
        }
    }

    console.log(`Fetching complete. Analyzed ${allProducts.length} products.`);

    allProducts.sort(function (a, b) {
        return a.priceFor100g - b.priceFor100g;
    });

    console.table(allProducts);
    console.log('Preparing CSV file...');
    
    let csvContent = "Name, Price, Price For 100g\n";
    allProducts.forEach(function(product) {
        csvContent += `"${product.name}","${product.price}","${product.priceFor100g}"\n`;
    });

    try {
        fs.writeFileSync('yerba_ranking.csv', csvContent, 'utf8');
        console.log("Results successfully saved to yerba_ranking.csv");
    } catch (err) {
        console.error("Error while saving the CSV file:", err.message);
    }
}

fetchAllProducts();