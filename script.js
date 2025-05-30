let carrinho = [];

function buscarProduto() {
    const codigo = document.getElementById('codigo').value.trim();
    console.log("Buscando produto:", codigo);
    if (!codigo) return;  // Evita buscar vazio

    fetch(`buscar_produto.php?busca=${encodeURIComponent(codigo)}`)
        .then(res => res.json())
        .then(prod => {
            console.log("Resposta da busca:", prod);
            if (prod.erro) {
                alert(prod.erro);
                return;
            }
            let existente = carrinho.find(p => p.codigo === prod.codigo);
            if (existente) {
                existente.qtd += 1;
            } else {
                carrinho.push({ ...prod, preco: parseFloat(prod.preco), qtd: 1 });
            }
            atualizarCarrinho();
        })
        .catch(err => console.error("Erro na busca:", err));
}

function atualizarCarrinho() {
    console.log("Atualizando carrinho:", carrinho);
    const tbody = document.querySelector("#carrinho tbody");
    tbody.innerHTML = "";
    let total = 0;

    carrinho.forEach((p, i) => {
        let subtotal = p.qtd * p.preco;
        total += subtotal;
        tbody.innerHTML += `
            <tr>
                <td>${p.nome}</td>
                <td>R$ ${p.preco.toFixed(2)}</td>
                <td>${p.qtd}</td>
                <td>R$ ${subtotal.toFixed(2)}</td>
                <td><button onclick="remover(${i})">Remover</button></td>
            </tr>`;
    });

    document.getElementById('total').textContent = total.toFixed(2);
}

function remover(index) {
    console.log("Removendo item:", index);
    carrinho.splice(index, 1);
    atualizarCarrinho();
}

function finalizarVenda() {
    if (carrinho.length === 0) return alert("Carrinho vazio!");

    fetch("salvar_venda.php", {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(carrinho)
    })
    .then(res => res.text())
    .then(dados => {
        alert("Venda registrada!");
        window.open(`gerar_recibo.php?id=${dados}`, "_blank");
        carrinho = [];
        atualizarCarrinho();
    })
    .catch(err => console.error("Erro ao finalizar venda:", err));
}

const input = document.getElementById('codigo');

input.addEventListener('keydown', function(event) {
    console.log("Tecla pressionada:", event.key);
    if (event.key === 'Enter') {
        event.preventDefault();  
        buscarProduto();
        input.value = '';  
    }
});

input.addEventListener('blur', () => {
    console.log("Input perdeu foco. Reforçando foco.");
    input.focus();
});

window.addEventListener('load', () => {
    console.log("Página carregada. Foco no input.");
    input.focus();
});