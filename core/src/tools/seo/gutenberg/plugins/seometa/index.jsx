const { registerPlugin } = wp.plugins
const { __ } = wp.i18n
const { Component, Fragment } = wp.element
const { withSelect, withDispatch } = wp.data
const { compose } = wp.compose
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost
const { PanelBody, PanelRow, Button, SelectControl, RangeControl, TextControl, ResizableBox, ToggleControl } = wp.components

registerPlugin('wkg-plugin-seometa', {
  icon: 'megaphone',
  render: (props) => {
    return (
      <Fragment>
          <PluginSidebarMoreMenuItem target="wkg-plugin-seometa">{__('Référencement', 'woodkit')}</PluginSidebarMoreMenuItem>
          <PluginSidebar name="wkg-plugin-seometa" title="Référencement" className="wkg-plugin-seometa">
              <PluginComponent />
          </PluginSidebar>
      </Fragment>
    )
  }
})

class PluginComponent_Base extends Component {
	constructor(props) {
		super(props)
	}
	render () {
		return (
			<Fragment>
				<PanelBody className="wkg-plugin-panelbody">
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Meta-title', 'woodkit')} value={this.props.meta_title} onChange={(value) => this.props.on_meta_change({'_seo_meta_title': value})} />
          </PanelRow>
				</PanelBody>
			</Fragment>
		)
	}
}

const applyWithSelect = withSelect(select => {
  let core_editor_store = select('core/editor')
  return {
    meta_title: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_title'],
    meta_description: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_description'],
    meta_keywords: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_keywords'],
    meta_og_title: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_title'],
    meta_og_description: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_description'],
    meta_og_image: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_image'],
  }
})

const applyWithDispatch = withDispatch(dispatch => {
  let core_editor_store = dispatch('core/editor')
  return {
    on_meta_change: (meta) => {
      core_editor_store.editPost({meta})
    },
  }
})

const PluginComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(PluginComponent_Base)

const styles = {}
