function CliqueLinha(linha, identificador){
  let resultado = 0;
  identificador = '#' + identificador;
  $(linha).toggleClass('selected');
  $(identificador + ' tr.selected').each(function(){
    resultado += $(this).data('value');
  });
  AtribuiValor(identificador + ' .resultado', resultado);

  
}
function LimparSomatoria(identificador){
  identificador = '#'+identificador;
    $(identificador + ' .selected').removeClass('selected');
    AtribuiValor(identificador + ' .resultado', 0);
}
function AtribuiValor(seletor, valor){
  $(seletor).html(formCurrency.format(valor))
}
const formCurrency = new Intl.NumberFormat('pt-BR', {
  style: 'currency',
  currency: 'BRL',
  minimumFractionDigits: 2
});





function teste(botao) {    
  let tableData = $(botao).closest("tr").find("td:not(:last-child)").map(function(){
     return $(this).text().trim();
  }).get();

  console.log(tableData);
}



























document.getElementById("btn").addEventListener("click", function(event){
  event.preventDefault();
})
document.getElementById("btn1").addEventListener("click", function(event){
  event.preventDefault();
})