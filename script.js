let carrinho = [];

/* ─── BUSCAR PRODUTO ─────────────────────────── */
function buscarProduto() {
  const input  = document.getElementById('codigo');
  const codigo = input.value.trim();
  if (!codigo) return;

  fetch(`buscar_produto.php?busca=${encodeURIComponent(codigo)}`)
    .then(res => res.json())
    .then(prod => {
      if (prod.erro) {
        mostrarMensagem(prod.erro, 'erro');
        return;
      }

      const existente = carrinho.find(p => p.codigo === prod.codigo);
      if (existente) {
        existente.qtd += 1;
      } else {
        carrinho.push({ ...prod, preco: parseFloat(prod.preco), qtd: 1 });
      }

      input.value = '';
      atualizarCarrinho();
      mostrarMensagem(`"${prod.nome}" adicionado ao carrinho.`, 'ok');
    })
    .catch(() => mostrarMensagem('Erro ao buscar produto. Tente novamente.', 'erro'));
}

/* ─── ATUALIZAR TABELA ───────────────────────── */
function atualizarCarrinho() {
  const tbody = document.querySelector('#carrinho tbody');
  const vazio = document.getElementById('carrinho-vazio');
  tbody.innerHTML = '';

  let total = 0;

  if (carrinho.length === 0) {
    vazio.style.display = 'block';
    document.getElementById('total').textContent = '0,00';
    return;
  }

  vazio.style.display = 'none';

  carrinho.forEach((p, i) => {
    const subtotal = p.qtd * p.preco;
    total += subtotal;
    tbody.innerHTML += `
      <tr>
        <td>${p.nome}</td>
        <td>R$ ${p.preco.toFixed(2).replace('.', ',')}</td>
        <td>${p.qtd}</td>
        <td>R$ ${subtotal.toFixed(2).replace('.', ',')}</td>
        <td><button class="btn-remover" onclick="remover(${i})" title="Remover item">&#10005;</button></td>
      </tr>`;
  });

  document.getElementById('total').textContent = total.toFixed(2).replace('.', ',');
}

/* ─── REMOVER ITEM ───────────────────────────── */
function remover(index) {
  carrinho.splice(index, 1);
  atualizarCarrinho();
}

/* ─── FINALIZAR VENDA ────────────────────────── */
function finalizarVenda() {
  if (carrinho.length === 0) {
    mostrarMensagem('O carrinho está vazio. Adicione produtos antes de finalizar.', 'erro');
    return;
  }

  fetch('salvar_venda.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(carrinho)
  })
  .then(res => res.text())
  .then(id => {
    window.open(`gerar_recibo.php?id=${id}`, '_blank');
    carrinho = [];
    atualizarCarrinho();
    mostrarMensagem('Venda finalizada! Recibo gerado em nova aba.', 'ok');
  })
  .catch(() => mostrarMensagem('Erro ao registrar a venda. Tente novamente.', 'erro'));
}

/* ─── MENSAGEM INLINE ────────────────────────── */
function mostrarMensagem(texto, tipo) {
  const el = document.getElementById('mensagem');
  if (!el) return;
  el.textContent = texto;
  el.className = `alerta alerta-${tipo === 'ok' ? 'ok' : 'erro'}`;
  el.style.display = 'block';
  clearTimeout(el._timeout);
  el._timeout = setTimeout(() => { el.style.display = 'none'; }, 3500);
}

/* ─── TECLADO ────────────────────────────────── */
const inputCodigo = document.getElementById('codigo');

if (inputCodigo) {
  inputCodigo.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarProduto();
    }
  });

  window.addEventListener('load', () => inputCodigo.focus());

  /* Reforça foco apenas quando o usuário clica fora dos botões */
  document.addEventListener('click', function (e) {
    const tag = e.target.tagName.toLowerCase();
    if (tag !== 'button' && tag !== 'a') {
      inputCodigo.focus();
    }
  });
}

/* Inicializa a view vazia */
atualizarCarrinho();
