# GameRig

**GameRig** è una piattaforma web realizzata in PHP per la vendita di componenti per PC da gaming.  
Il sito permette agli utenti di sfogliare, cercare e acquistare componenti come CPU, GPU, RAM, schede madri e case, con funzionalità di carrello, gestione utente e recensioni prodotti.

## Caratteristiche principali

- **Catalogo componenti**: Visualizza e filtra prodotti come CPU, GPU, RAM, schede madri e case.
- **Ricerca avanzata**: Barra di ricerca per trovare rapidamente i componenti desiderati.
- **Gestione utente**: Login, profilo personale e visualizzazione ordini.
- **Carrello acquisti**: Aggiungi, rimuovi e acquista prodotti.
- **Recensioni**: Sistema di recensioni e valutazioni per ogni componente.
- **Consigli tecnici**: Sezioni informative su cosa considerare durante la scelta dei componenti.
- **Pagina “Dove siamo”**: Mappa integrata per la localizzazione del negozio fisico.

## Tecnologie utilizzate

- **Backend**: PHP, MySQL (connessione locale)
- **Frontend**: HTML5, CSS3, JavaScript
- **Librerie/UI**: Google Material Icons
- **Database**: `GameRig` (con tabella prodotti, utenti, ordini, recensioni, ecc.)

## Struttura del progetto

- `index.php`: Homepage con overview dei prodotti e navigazione.
- `cpu.php`, `gpu.php`, `ram.php`, `motherboard.php`, `case.php`: Pagine dedicate alle categorie di componenti.
- `prodotto.php`: Dettaglio prodotto.
- `carrello.php`: Gestione carrello.
- `utente.php`: Profilo utente.
- `recensisci.php`: Inserimento recensioni.
- `ricerca.php`: Gestione risultati di ricerca.
- `acquisto.php`: Flusso d’acquisto.
- `/scripts/`: Script JavaScript per interazione UI (es. cambio immagini GPU, menu hamburger).
- `maps.html`: Mappa negozio fisico.
- `style.css`: Stili grafici.

## Installazione e Avvio

1. **Clona la repository:**
   ```bash
   git clone https://github.com/federico-castellani/gamerig.git
   ```
2. **Configura il database MySQL:**
   - Crea un database `GameRig` e importa le tabelle necessarie.
   - Aggiorna le credenziali di accesso nel codice PHP (`localhost`, `esame`, `esameWeb25`).
3. **Avvia localmente tramite server compatibile con PHP (es. XAMPP, MAMP).**
4. **Accedi tramite browser a `index.php`.**

## Note

- Tutte le pagine sono in lingua italiana.
- Il progetto è pensato come esempio didattico/accademico.
- Le credenziali MySQL sono hardcoded a scopo dimostrativo, **modificarle in produzione**.
- Nessuna licenza specificata.

---

**Autore:** [federico-castellani](https://github.com/federico-castellani)
