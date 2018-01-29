var bibRelator = {
    baseUrl: 'https://dev-www.nypl.org/books-music-dvds/recommendations/best-books/ya/',
    insertSelector: '#allItemsSection',

    extractBib: function(path) {
        if (path.indexOf('iii/encore/record') !== -1) {
            var matchedArray = /\/.+(?:Rb)(\d+)(?:.+)?/.exec(path)
        }

        if (matchedArray) {
            return matchedArray[1]
        }
    },

    getRelatedBibs: function() {
        var bib = this.extractBib(window.location.pathname)

        if (bib) {
            jQuery(this.insertSelector).before(
                '<iframe src="' + this.baseUrl + bib + '" frameborder="0" scrolling="no" id="related-bibs" style="border: 1px solid #000"></iframe>'
            )
        }
    }
}

bibRelator.getRelatedBibs()
