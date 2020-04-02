const { Component } = wp.element
const { SelectControl } = wp.components

 export default class SelectControlObj extends Component {

  constructor (props) {
    super(props)
    this.state = {
      selected: null
    }
  }

 	componentDidMount () {
    if (this.props.value_key === undefined) {
      throw new Error('component must contains \'value_key\' prop')
    }
 		this.setState({
 			selected: this.props.value && this.props.value_key ? this.props.value[this.props.value_key] : this.props.value
 		})
 	}

 	_onChange (key) {
 		if (this.props.onChange) {
 			this.setState({
 				selected: key
 			})
 			let selected = this.props.options.filter(obj => obj.value[this.props.value_key] === key)
 			this.props.onChange(key, selected.length > 0 ? selected[0].value : null)
 		} else {
 			console.warn('\'onChange={(key, value) => func()}\' props missed')
 		}
 	}

	render () {
    let options = []
		if (this.props.options) {
			this.props.options.forEach((obj) => {
        if (obj.value === undefined || obj.label === undefined) {
  				throw new Error('Each option must be an object like {value: Object, label: String}')
        }
        if (obj.value[this.props.value_key] === undefined) {
          throw new Error('Each option must have value Object with this key : \''+this.props.value_key+'\'')
        }
        options.push({value: obj.value[this.props.value_key], label: obj.label, disabled: obj.disabled})
			})
		} else {
			options.push({value: null, label: this.props.loadingLabel || 'Chargement...', disabled: true})
		}
  	return (
			<SelectControl
        label={this.props.label}
				options={options}
				onChange={key => this._onChange(key)}
				value={this.state.selected}
			/>
    )
  }
}

const styles = {}
