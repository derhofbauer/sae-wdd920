(function () {
  console.log('Works?! :D')
  console.log('Really?!')
  console.log('Yep!! :D')

  /**
   * @todo: comment
   */
  document.querySelectorAll('.add-to-cart').forEach((button) => {
    button.addEventListener('click', async (event) => {
      event.preventDefault()

      const url = event.target.href

      const result = await fetch(url)
      const json = await result.json()

      document.querySelectorAll('.cart-counter').forEach((counter) => {
        counter.textContent = json.count
      })
    })
  })
})()
