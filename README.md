# Web Starter Kit

Simple router and Twig parser.  

- Define controller routes in `routes.json`
- Comes with one built-in controller, `ab\Front\Controller\TwigByUri` which will parse twig by URI.
- Controllers should expect `(ServerRequestInterface $request, array $routerArguments)`
- Controller's `__invoke()` argument is called if no method is explicity defined in `routes.json` (per `League\Route`).
- When using `TwigByUri`, drop templates in `templates/` names `{uriPath}.twig.html`, and `home.twig.html` for `/`.
- Else, define your own controller and optionally use `\ab\Front\TwigRenderer::loadAndRender()` for twig parsing.

Could easily be adapted as an over-arching framework with other more proprietary frameworks living underneath, side-by-side.
Or, could be used as a ridiculously simple framework/CMS.  Less than 200 lines.  Do one thing, and do it well.

## To-Do

 - `dev-router.php` is a mess.
 - documentation via phpDoc.
 - cleaner namespace names, better class names.  these will probably change.

MIT license.

(C) Copyright A.B. Carroll <ben@hl9.net>

