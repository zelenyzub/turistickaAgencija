<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Online kupovina</title>
</head>

<body>
    <div class="container">
        <form>
            <div class="col-md-3">
                <label for="imeNosioca" class="form-label">Ime Nosioca Osiguranja:</label>
                <input type="text" class="form-control" id="imeNosioca" placeholder="Unesite ime nosioca osiguranja">
            </div>
            <div class="col-md-3">
                <label for="prezimeNosioca" class="form-label">Prezime Nosioca: </label>
                <input type="text" class="form-control" id="prezimeNosioca"
                    placeholder="Unesite prezime nosioca osiguranja">
            </div>
            <div class="col-md-3">
                <label for="vrstaOsiguranja" class="form-label">Vrsta Osiguranja</label>
                <select id="vrstaOsiguranja" class="form-select">
                    <option selected>-----Izaberite Vrstu Osiguranja-----</option>
                    <option value="individualno">Individualno</option>
                    <option value="grupno">Grupno</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="telefon" class="form-label">Telefon Nosioca: </label>
                <input type="text" class="form-control" id="telefon"
                    placeholder="Unesite telefon nosioca osiguranja">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
