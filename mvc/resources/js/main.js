(function () {
  console.log('Works?! :D')
  console.log('Really?!')
  console.log('Yep!! :D')

  /**
   * Add-to-cart Button AJAX
   *
   * Für jedes Element mit der Klasse add-to-cart ...
   */
  document.querySelectorAll('.add-to-cart').forEach((button) => {
    /**
     * ... fügen wir eine EventListener auf das click-Event hinzu.
     */
    button.addEventListener('click', async (event) => {
      /**
       * Zunächst unterbinden wir das Standardverhalten, weil wir meistens mit
       * a-Tags arbeiten werden und nicht an die URL im href-Attribut
       * weitergeleitet werden wollen, sondern hier alles im JavaScript machen.
       */
      event.preventDefault()

      /**
       * Zunächst holen wir uns die URL aus dem href-Attribut des a-Tags, damit
       * wir wissen, an welche URL der AJAX Request geschickt werden soll.
       *
       * @type {string}
       */
      const url = event.target.href

      /**
       * Dann senden wir einen GET-Request mit der fetch()-Funktion an diese
       * URL.
       *
       * Beachte hier das await-Keyword, dass den eigentlich asynchronen und
       * nicht-blockierenden JavaScript Code hier anhält, bis der Request
       * abgeschlossen ist und eine Response empfangen wurde. Das funktioniert
       * nur, wenn die ganze Funktion als async definiert wird (s. :15)
       *
       * @type {Response}
       */
      const result = await fetch(url)
      /**
       * Im Anschluss holen wir die Daten als JSON aus der Response.
       *
       * @type {object}
       */
      const json = await result.json()

      /**
       * Nun gehen wir alle Elemente mit der Klasse cart-counter durch und
       * aktualisieren den Wert mit dem count-Attribut aus der Response.
       */
      document.querySelectorAll('.cart-counter').forEach((counter) => {
        counter.textContent = json.count
      })
    })
  })
})()
