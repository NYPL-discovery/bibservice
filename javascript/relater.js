var bibRelator = {
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
            jQuery.get('https://platform.nypl.org/api/v0.1/bibs/sierra-nypl/' + bib + '/related-simple', function (data) {
                var html = ''

                html += '<div id="relatedNypl">\n' +
                    '<span class="bibInfoHeader customHeader">Also at NYPL</span>\n' +
                    '<div style="overflow: auto">\n' +
                    '<table>\n' +
                    '<tr>\n'

                jQuery.each(data.data, function (index, bib) {
                    html += '<td style="padding: 10px 25px 10px 0; max-width: 180px">\n' +
                        '<div style="margin-bottom: 8px"><a href="/iii/encore/record/C__Rb' + bib.id + '"><img src="https://contentcafe2.btol.com/ContentCafe/jacket.aspx?UserID=ebsco-test&Password=ebsco-test&Return=T&Type=M&Value=' + bib.isbns[0] + '" style="max-height: 200px" /></a></div>\n' +
                        '<div><a href="/iii/encore/record/C__Rb' + bib.id + '">' + bib.materialType + ' | ' + bib.publishYear + '</a></div>\n' +
                        '<div style="font-style: italic; margin-top: 4px">' + bib.publisher + '</div>\n'

                    if (bib.language !== 'English') {
                        html += '<div style="margin-top: 4px">' + bib.language + '</div>\n'
                    }

                    //'<div style="margin-top: 4px">' + bib.title + '</div>\n' +
                    html += '</td>\n'
                })

                html += '</tr>\n' +
                    '</table>\n' +
                    '</div>\n'
                '</div>\n'

                jQuery('#moreDetailsAnyComponent').prepend(html)
            });
        }
    }
}

bibRelator.getRelatedBibs()
