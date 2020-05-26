import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { Button, SelectControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

class WKG_Term_Selector extends Component {

  constructor (props) {
    super(props)
    this.state = {
      selected: null
    }
  }

 	componentDidMount () {
 		this.setState({
 			selected: this.props.value && this.props.value.id ? this.props.value.id : this.props.value
 		})
 	}

 	_onChange (value) {
 		if (this.props.onChange) {
 			this.setState({
 				selected: value
 			})
 			this.props.onChange(parseInt(value))
 		} else {
 			console.warn('WKG_Term_Selector doit recevoir la propriété \'onChange={value, term => func()}\'')
 		}
 	}

	render () {
    let options = []
    if (this.props.terms_options) {
      for (const taxonomy in this.props.terms_options) {
        const taxonomy_options = this.props.terms_options[taxonomy]
        if (taxonomy_options) {
          options.push({value: 0, label: taxonomy_options.taxonomy_label, disabled: true})
          if (taxonomy_options.options) {
            for (var taxonomy_option of taxonomy_options.options) {
              options.push({value: taxonomy_option.value, label: taxonomy_option.label, disabled: taxonomy_option.disabled})
            }
          }
        }
      }
    } else {
      options.push({value: 0, label: this.props.label_loading ? this.props.label_loading : 'Chargement...', disabled: true})
    }
  	return (
			<div className="wkg-term-selector">
				<SelectControl
          label={this.props.label}
					options={options}
					onChange={value => this._onChange(value)}
					value={this.state.selected}
				/>
			</div>
    )
  }
}

const applyWithSelect = withSelect((select, props) => {
  const { getTaxonomies } = select('core')
  const { getTermsOptions } = select('wkg/commons')

  /********************************************************/
  /* GET TERMS OPTIONS                                    */
  /********************************************************/
  if (!props.taxonomies) {
    // default taxonomies
    let taxonomies = getTaxonomies()
    if (taxonomies) {
      props.taxonomies = taxonomies.map(tax => tax.slug)
    }
  }
  let terms_options = getTermsOptions(props.taxonomies)
  return { terms_options }
})

export default compose(
    applyWithSelect,
)(WKG_Term_Selector)
