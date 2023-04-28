const base64Produc = {};
const columnDefsExcel = [{
  field: 'Imagen'
}, {
  field: 'Referencia'
}, {
  field: 'Descripcion',
}];

const createBase64ImageFromURL = (url) =>
  fetch(url).then((response) => response.blob()).then((blob) => {
    return new Promise((res) => {
      const reader = new FileReader();
      reader.onloadend = () => res(reader.result);
      reader.readAsDataURL(blob);
    });
  });

const createBase64ImagesFromURLArray = (arr, base64ProducObject) => {
  const promiseArray = arr.reduce((promises, currentUrl) => {
    if (!base64ProducObject[currentUrl]) {
      const promise = createBase64ImageFromURL(currentUrl);
      promise.then((base64) => base64ProducObject[currentUrl] = base64);
      promises.push(promise);
    }
    return promises;
  }, []);
  return Promise.all(promiseArray);
};

const createBase64ProducFromResponse = (response, base64ProducObject) => {
  return response.json().then((data) => {
    const urls = data.map((product) => product.Imagen);
    return createBase64ImagesFromURLArray(urls, base64ProducObject).then(() => data);
  }).then((data) => data);
};

const gridOptions = {
  getRowHeight: params => params ? 5000 : 20000,
  columnDefs: columnDefsExcel,
  defaultExcelExportParams: {
    addImageToCell: (rowIndex, col, value) => {
      if (col.getColId() !== 'Imagen') return;

      return {
        image: {
          id: value,
          altText: 'Imagen',
          base64: base64Produc[value],
          imageType: 'png',
          width: 90,
          height: 90,
          position: {
            offsetY: 10,
            offsetX: 10,
          },
        },
      };
    },
  },
  context: {
    base64Produc: base64Produc
  },
  onGridReady: (params) => {
    fetch(rutaBase + "ExportarExcel")
      .then((data) => createBase64ProducFromResponse(data, base64Produc))
      .then((data) => {
        params.api.setRowData(data)
        gridOptions.api.exportDataAsExcel({
          fileName: 'Productos.xlsx',
          rowHeight: 120,
          headerRowHeight: 20
        });
        $(".loading-fotos").find('span').text('Sincronizando fotos...');
        $(".botones-acciones").removeClass('d-none');
        $(".loading-fotos").addClass('d-none');
      });
  },
};