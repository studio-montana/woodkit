const { registerPlugin } = wp.plugins
const { __ } = wp.i18n
const { Component, Fragment } = wp.element
const { withSelect, withDispatch } = wp.data
const { compose } = wp.compose
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost
const { PanelBody, PanelRow, TextControl } = wp.components
import WKG_Media_Selector from 'wkgcomponents/media-selector'
import WKG_Icons from 'wkgcomponents/icons'

registerPlugin('wkg-plugin-seometa', {
  icon: WKG_Icons.seo,
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
          <h4>{__('Moteurs de recherche', 'woodkit')}</h4>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Titre', 'woodkit')} value={this.props.meta_title} onChange={(value) => this.props.on_meta_change({'_seo_meta_title': value})} />
            <div className="wkg-info">{__('Par défaut, le titre de la publication sera utilisé.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Description', 'woodkit')} value={this.props.meta_description} onChange={(value) => this.props.on_meta_change({'_seo_meta_description': value})} />
            <div className="wkg-info">{__('Par défaut, le résumé de la publication sera utilisé.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Mots-clés', 'woodkit')} value={this.props.meta_keywords} onChange={(value) => this.props.on_meta_change({'_seo_meta_keywords': value})} />
            <div className="wkg-info">{__('Séparez les mots-clés par une virgule.', 'woodkit')}</div>
          </PanelRow>
				</PanelBody>
				<PanelBody className="wkg-plugin-panelbody">
          <h4>{__('Réseaux sociaux', 'woodkit')}</h4>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Titre', 'woodkit')} value={this.props.meta_og_title} onChange={(value) => this.props.on_meta_change({'_seo_meta_og_title': value})} />
            <div className="wkg-info">{__('Par défaut, le titre utilisé pour les moteurs de recherche sera utilisé.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Description', 'woodkit')} value={this.props.meta_og_description} onChange={(value) => this.props.on_meta_change({'_seo_meta_og_description': value})} />
            <div className="wkg-info">{__('Par défaut, la description utilisée pour les moteurs de recherche sera utilisé.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <WKG_Media_Selector show label={__('Image', 'woodkit')} value={this.props.meta_og_image && this.props.meta_og_image !== 0 ? this.props.meta_og_image : null} onChange={(media) => this.props.on_meta_change({'_seo_meta_og_image': media && media.id ? media.id : 0})} />
            <div className="wkg-info">{__('Par défaut, l\'image mise en avant de la publication sera utilisée.', 'woodkit')}</div>
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
      console.log('update meta - ', meta)
      core_editor_store.editPost({meta})
    },
  }
})

const PluginComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(PluginComponent_Base)

const styles = {}
