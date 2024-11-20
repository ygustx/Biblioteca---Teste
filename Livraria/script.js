document.addEventListener("DOMContentLoaded", () => {
    const formAdicionarLivro = document.querySelector("#form-adicionar-livro");
    const listaLivros = document.querySelector("#lista-livros");
    const botaoSair = document.querySelector(".logout-button");

    /**
     * Função para salvar livros no Local Storage
     * @param {Array} livros - Lista de livros atualizada
     */
    function salvarLivrosNoLocalStorage(livros) {
        localStorage.setItem("livros", JSON.stringify(livros));
    }

    /**
     * Função para carregar livros do Local Storage
     * @returns {Array} - Lista de livros carregada
     */
    function carregarLivrosDoLocalStorage() {
        return JSON.parse(localStorage.getItem("livros")) || [];
    }

    /**
     * Função para renderizar a lista de livros
     */
    function renderizarLivros() {
        const livros = carregarLivrosDoLocalStorage();
        listaLivros.innerHTML = ""; // Limpa a lista antes de renderizar

        livros.forEach((livro, index) => {
            const livroItem = document.createElement("li");
            livroItem.classList.add("livro-item");
            livroItem.innerHTML = `
                <div class="livro-detalhes">
                    <strong>${livro.titulo}</strong><br>
                    <span>Autor: ${livro.autor}</span><br>
                    <span>Preço: R$ ${livro.preco.toFixed(2)}</span><br>
                    <span>Estoque: ${livro.estoque}</span>
                    <img src="${livro.imagem}" alt="Capa do Livro" style="width: 100px; height: auto; margin-top: 10px;">
                </div>
                <button class="remover-livro" data-index="${index}">Remover</button>
            `;

            // Evento para remover livro
            livroItem.querySelector(".remover-livro").addEventListener("click", (event) => {
                const indexToRemove = event.target.dataset.index;
                const livrosAtualizados = carregarLivrosDoLocalStorage();
                livrosAtualizados.splice(indexToRemove, 1); // Remove o livro
                salvarLivrosNoLocalStorage(livrosAtualizados);
                renderizarLivros(); // Atualiza a lista
                alert("Livro removido com sucesso!");
            });

            listaLivros.appendChild(livroItem);
        });
    }

    /**
     * Função para finalizar uma compra
     * @param {string} tituloLivro - Título do livro selecionado
     */
    function finalizarCompra(tituloLivro) {
        const livros = carregarLivrosDoLocalStorage();
        const livroAtualizado = livros.find((l) => l.titulo === tituloLivro);

        if (livroAtualizado) {
            if (livroAtualizado.estoque > 0) {
                livroAtualizado.estoque -= 1; // Atualiza o estoque
                salvarLivrosNoLocalStorage(livros);
                alert("Compra finalizada com sucesso!");
            } else {
                alert("Estoque insuficiente.");
            }
        } else {
            alert("Erro ao localizar o livro no estoque.");
        }
    }

    /**
     * Evento para adicionar um livro
     */
    formAdicionarLivro.addEventListener("submit", (event) => {
        event.preventDefault();

        const titulo = document.querySelector("#titulo").value.trim();
        const autor = document.querySelector("#autor").value.trim();
        const preco = parseFloat(document.querySelector("#preco").value);
        const estoque = parseInt(document.querySelector("#estoque").value, 10);
        const imagem = document.querySelector("#imagem").files[0];

        if (!titulo || !autor || isNaN(preco) || isNaN(estoque) || !imagem) {
            alert("Preencha todos os campos corretamente!");
            return;
        }

        const imagemSrc = URL.createObjectURL(imagem);
        const livros = carregarLivrosDoLocalStorage();
        livros.push({ titulo, autor, preco, estoque, imagem: imagemSrc });
        salvarLivrosNoLocalStorage(livros);
        renderizarLivros();
        formAdicionarLivro.reset(); // Limpa o formulário
        alert("Livro adicionado com sucesso!");
    });

    /**
     * Evento para sair da página administrativa
     */
    botaoSair.addEventListener("click", () => {
        if (confirm("Tem certeza que deseja sair?")) {
            window.location.href = "Livraria.html";
        }
    });

    // Inicialização
    renderizarLivros();
});
