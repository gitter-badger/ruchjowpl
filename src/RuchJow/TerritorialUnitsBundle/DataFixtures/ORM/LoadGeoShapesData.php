<?php

namespace RuchJow\TerritorialUnitsBundle\DataFixtures\ORM;

use Symfony\Component\Finder\Finder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RuchJow\TerritorialUnitsBundle\Entity\Commune;
use RuchJow\TerritorialUnitsBundle\Entity\District;
use RuchJow\TerritorialUnitsBundle\Entity\Region;
use RuchJow\TerritorialUnitsBundle\Entity\GeoShape;

class LoadGeoShapesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        $regionsSrcFile   = __DIR__ . '/../src/geo/country-regions.json';
        $districtsSrcFiles = __DIR__ . '/../src/geo/regions-districts';
        $communesSrcFiles = __DIR__ . '/../src/geo/communes';

        $regionShapes   = array();
        $districtShapes = array();

        $regionsRepository   = $manager->getRepository('RuchJowTerritorialUnitsBundle:Region');
        $districtsRepository = $manager->getRepository('RuchJowTerritorialUnitsBundle:District');
        $communesRepository  = $manager->getRepository('RuchJowTerritorialUnitsBundle:Commune');

        $regionsByImportId = array();
        $districtsByImportId = array();


        // 1. country shape
        $countryShape = new GeoShape();
        $countryShape
            ->setShape('w`alIgp|dBnD{pHsD}oAyn@syDoa@whEyOwaAmK`A|HgAaMorA{GaW{PPxRwOqKy}Dyu@odE}oAcbF_{CemHciEivH_MehAwm@mpCutBw~K}gDm`Nam@ajDqcAcuMmV{w@cKikAwUkdGgIs{Ho]g_HwZivC{NkqD_Naj@fFaJsGc_Cc^wtFaw@aqIsfBaoNct@ubLyqAyvLmZ{fEu]meIgR{{RvIkgH}DmfNfBwnEqRasKpIuqF|b@ijAjw@ufAjc@grAxqAisF~OivArDkKqCtIbR`P`h@gaBzlE}gQbvCwmLvrBsjJdeBigGxbBatEtzCqpHxxD{iG`VsQ`~AwKjg@v]~g@x|@gB`b@_f@h\\tArV}_@mJoOnRyFjQtIpLaWbc@}Lns@ip@~FyfBbtAkgF~qGkw@thAsbAfdCzKlw@mBv]me@h\\gEn}Aex@bgAwlAjpC_f@|iCywBlqImHrtAwS`UkPzLyi@jeDw\\ztAc_@ls@aEbu@gm@rzA{LbjAqf@p~AvJfPtIaFlBlMxSyHvYnYlVqMrQhJny@zdAtsA~x@xmBvQrL{RvY{aAjDafAjw@e{A`y@ctAny@w~Cxs@nj@|~BmDz`@fRrWiHl_@m{@~m@nZvTy\\fDpVaErOlQ}ElKjL~OeRxL}lAaQc|C_\\gp@prAja@jaAiEjjCypBlk@mgArhAen@zsA}Trp@ch@f{A}UvwBrFwEpd@~IfJq@nRzO`BdfBuoA|iAqd@r|@jj@zgAfCne@qFrl@_^rlAalAhp@ocA`oA_vClr@gzCvEwy@aEcj@gLy_@m`@bPpUaNdh@gzBpoA{eAht@}wAaOuRfQm^yZek@rKiR|i@dl@n_@k`BfZyjGsAy]aWbLzj@wm@zz@chFfj@{gElVqzDrF{~CcDgoAu[{iAah@eY|K~PwFfDid@umArb@`TsByWwCuXuIaCjf@{aAxMv@~LkUp\\q`C?ulMkWs|Nyn@umSq}@q}NykA}|LctBamNevAeaH_}A}dGgkAoxD}wBstFh^i{@ncAex^xlBmge@dOu`KfU{}Fl|@kuT|g@gaQrEwrB``@otDtQkgGx]kzEr_@_bLdLg{@w@}`CzPckHda@{lE~e@swAm]oiBu@qb@aCasF~P}xCI}pCzx@_dNgCwzD`MarFpKgpFiCs}CnNqi@jEinHl^gcE~LowGwDui@n\\_mIz_@oaCaB{jEpQysCdg@qoIqWgdBsFskAbYibCsIozIpR{vAtIy`CgCexBpC{Sbm@mr@uFqkCwWonDaHylEj@muCtMoAdAce@`B}bA}SaTc@aWuJmfJxBedGcQweKaLuhJfBemIgNahKlAkxCxB_eE}Tc|FtBq~HcJs_F|Ds`GgIaiFrDeU{FyKe`@csGnScUj@aPcHui@fF}cCcCikFnCqaCoIkCsMc|@tFkHkAi{BeNitIsMifBtLgnAcNylA}CeuGx@cdFg\\kmG`Ak{CmLc}B|Ji{CcJauBi\\_}BgRgwTyn@kxB}|EozCuCyoAyRaa@dKooA}Bu~Bbx@bB}AmaAhYocFr_@kiDxG{gCl^yD|I_~CraCzdBre@u_Bxg@onF~Vc`AlZo^jm@nkAlf@n[heAnY`Rsn@lyAchGgC_n@i^}l@whAooE|Hos@t\\ocAvmA~`@xKu~ApXoi@~LoaD~_@iRb_@gd@jf@}kAtcAc~@|UclAmTi}ErUmj@pHep@vVs~Fvd@ccA`oAobAlQyj@gBom@lHsn@rXka@p_@tFhPcu@b{@kVn^wc@pc@}Nr_@ynA~sAg`@lKwvEpo@}LdZkxAh`@xLz[ax@n@gTlmBg`@rQaYh`B~OzWaWPwa@~rA{]r{@_fAndAMpoAy~@rv@zOrz@}Gh{@hXhYwP~MxFrNfu@`j@r\\lVaJle@pYpXxq@rAyNzE~AgMn`@lMu@}Dp[jJvOxLaDhVxk@aBnMjJjFp`@kXlSnNu@aPfYt@fSyPsBqIzTdSvK}TbOlAbIgR_BmS`JcPzLfQ~FqHsCkWrJ^lEmi@tGpJlN{k@zEpH`EeYfHjExD{KnGvIj|FnRldHy{An[iCc@jOdKvAx@aYzHOrToi@}E{_@bIcKn@u_@ha@{ZlJ|EnGf_@jPtBrYal@be@|ZvUge@tCp\\jUnPj}D|I~pD_ZvtCwmEt_B_UrlC`A~{@eT~lQi`FteJ_gDhmCgq@xu@cn@fkNyeGn|CagB|_FaeCxqGydCpsIw{Dn{DszBfkAucF`cAce@pTVjFjMdFoShH`AtSt\\ti@ei@jGfLp^qDlC}NpDzGnMqe@kDiGjPsLdIe`@zAtIjAaRjQuChO}o@hJpDiAuNd_@eZdAom@|Xia@d]aJnDc\\]rJ~IuCbEdPiBcLfHkN|a@|Dw@mZlLjF|@zNhL}GlR`f@nj@}d@hP`WvMu@{@jTjGlHsGhGrQ|ClIhQmDvF~PtBiCrMpHvFxSyB~DfUxGmXj@bZhp@pWjCnPlLwCeA|LdN_BPyR~XxQaAuKtQmCtVbh@xQwEtCrMlIgJfG~J~DkKxC~ObHoByAhRp\\lVfLgD~CfP|^aM{AeZhSqD~CtLgAiLdJmMbD|Oz@{Mji@kErGkNrNyGqEuJzHc`@}CsLtNk`@tLqKfo@`[lBuMvGpEy@kR`KcRdIvDh@yf@~MfFxLkf@rNfApS|a@dZkGv[_w@zBu[daFyp@vc@xWnf@yIjlBw}Ah{BfyDtsEl@xA_Upa@sd@~hLhFflBo|A~pJbCv_Gt@|fC|oFtfAbn@?bqAngIngRx[x^x@bY|e@haA|L~l@qCvPbNnc@Rlb@ba@~]gNbF?|Okb@rfAxk@hcNb_@bzBhr@tsEruA~gHx`BnvFt}AbsEvw@tu@t_A~hCrrBxkD`iGp`I`gGjjGlnAzUn~@z_AvcA|gCzb@tc@|eJf`JtaHvgFQeSd_@yyBbNcS|o@l\\jaA{c@lmB|fAdpAuz@tG}~A`^sjBpEysAvYsmBMuc@ee@aeCqAkaA`XkJlNtLjG~c@dKH`Vs`B}OygAf[_fAmVuj@sC{o@pHaMpTlRhGuG_Uiy@`Gij@hu@eDxLyQX{}@mL}^}OqJgBe]rGqHrU`QdFia@nJ_Ole@r[vg@uErOqOqA}\\gUgZcEc^bx@wo@xEk]qb@ckA{^ma@lB_g@qKcg@jEmWzd@lAnSaa@SgXmj@gyAxD_~@tOsq@pYcSpIbx@cPxDwBdZb^yQtJhb@`UzWb]kU|^dO~RqFx[}mAgTac@rC_Zfh@{Zlc@tEcGuZxa@{NrHob@wFue@fScXtGo^hs@kFfYs^jW`C~K_NyEge@ok@t@_IqQxU{w@uY_kA~Nul@cBsy@~Vkm@h_@_^w@sm@`J{QzL`AnExi@tLfMra@gWhn@}gAnQixAvt@}O|Mg_@uAuSbP{Mjm@tz@jMgSRif@pUiGsIz`AzLpKdVueAtdAeWjVs^do@pKhq@wMba@zb@vXk|@rz@kk@dRo\\jGo]zN\\ve@e`@jb@~Szo@|_CxY}@xm@w]`KhE~ExnBbz@j|@xF|bAdS~VhL_LyO}v@nBqN~h@^h]ma@vb@nErErlAdy@pK_Sx_Adg@vo@vo@{r@xm@pKnVyrAhd@qf@dKdFr]zrAxKxF`j@ms@h[~@wCv`@gXpj@Ezb@bKf_@v`BkSr[wk@vZv_@lf@j@tNj[rCfe@~LbFhFyw@fLxBtMjh@fW}CjBm[qJk}@xDgXv[wQv_@hQ|Jkj@rRiH|`Am}@~ZgH|`@~j@fIiP`KfBzDdImGz[rGtJdZyO~h@jCv@jHcQx@cA~K`Pm@hLlXnCrm@hN{GtKdJwBfdA|Evi@hnAl|@mDnb@vSni@sA~w@yXph@vWnNtQvg@re@|WxQ`a@`Mz|@`e@sIlo@d_@vFkm@dZ~AnFsRmGwe@uUqBhAeQlq@gGbQk\\~d@nb@pBqj@~McGpQdk@tPy~@|MyIbPp]v[zC|i@xc@fTkk@th@dVty@kd@pMnVcCtc@fHtU|WlLfGzTh_@iZdL|Tt`@dNwFyZjZug@tXrEpR~r@rQgZr^`Db]kUr^dKxUfYnDuPjf@oDhRhVdYiu@`e@}H~UeWdZlFfIoQtCqo@|KqR~TcD~`@rWnS}^|_@lD|Jai@lOkQjk@pnAvc@rOv{@mObLwb@Taf@vSqr@o]cWgHk^bf@mr@^i_Ave@oIlu@g`A|U`n@rk@lDjNqr@`Q~^rGiBtKgk@nQ}QxEqc@j\\kLkAssAwVsT{CmYbNyUfQ_DrL{c@nr@eIrGsU~OcEe@px@vVtGlMt`@pPzJbQxb@oAr_@dJxDnWs[lPjLtFuMfW|E`JubAqGoj@lYar@iX_l@jCePzk@x[jUa[~C`q@h[eBlKif@`m@eYfAk`@iLki@dEaKhLnIfS|r@xMwLlB{k@fVnc@~JoClBqXtJaIrBjc@rYdd@uEjTxFv^jEfCrKg`@jIvAwIbf@hH~TpUmR~Lgx@lFbZ~SzA_GhX|EpI`NyNlZ~RpEqL{LoGN_Qpb@jIxVeWnDzRqFr_@zNrUmGro@zOfI`YmXvBhNiMx\\b[mFiEng@rg@lJxFoTtErXlTxBnKeMxFde@nKyp@jNpHcClu@j`@hL|^pw@bM~@Qq]lFgGvOb]pWfJld@{r@|PzA}@tVjXkGxk@cfA~F~`@`XuSfInYvNoT|OfEeIm\\xJoYmMqCcQu]Bac@pIjAhCkMqNsk@|KxA_HmTfHcDwCyT|OzChKoUe@cZkL_QiQvA`t@aOtIwSy@uTh\\u_@rMvVmDk^dMlElXsYsLcPvIsCx@iSpFfPnFqJvPrLmC_NdU}OBwXhDhSlE_PrHlQzj@oNjZfHzFwNjBuSfRt@kD~U~NuD~FcZB~[rLXj]elAxX}@`@kM~PkHlUl@vGzi@do@}UuAmPaPJjTgVsG_BrKqVoHuf@lH}F|FfJtJqWf]aB}OmObRhA^mW|MyJqA}l@|Gsj@|MdNpDqQ|WrEbL}OtJujAxNs[b@ih@ld@mc@lV`Lj[eLhV}kArBd^`\\wOuFoPrQwHoL{BbDuWmMoNfYwNi]g]~IqGrJzMhCsw@x\\zEmOcaAxP}OhTfD~F}i@dP~VnNgd@~QzThI_Np`AxArMdr@wUlGpSh^_QtEpZbC~MrWvIaUdXvEHs_@bWhKdHsj@rMl`@tKsJfBoVjCz]|Wq[tSj`@jRy[iNoP`DmPtNBzNcDuIcLzB}IpX|ErrAi`@mAwUyQn@uIob@|S}Gq@eUr[wMaMoWpOcKPy^uZ}M~Vy`@hNvDnLyMbc@pV~DwXnyAqRdKnMl@}e@b]fj@`LoQdCsa@xM^yJed@xAiYtT|q@ve@tm@vGe`@xHnQz`@ow@bFxUdN|@gDci@bO}a@hJpEuHrI|Bh[{ErNvMv@q@fUvRk@_Pfh@rLpD~CmVpMlTzHkp@yBof@|O_o@jt@_bAmAyPrMcVfuAylA|nAyDdi@}QrNnOne@wIpHe\\zSgIcOiU`M}I`Uay@ryAuh@nQ{u@ra@u]fV_qAphAevA~T}w@zSkUpb@oD`FsVeJkh@`HifAtGgh@~NaPkKyUrkAwpAhF_pArc@aYkKoe@jTsQl@cl@`HkQqOuPn@kj@nbAhNpx@deA~I~n@tLtAhA`f@vS~O~RjwAzLfCzAzzAuFvZ`MQuEtXrGhNaLx|@nLtEiGzOlEb_@qJtR~Af^tLhTeRtYqIel@sF`nApUfNaQdScG_K{GlJpArLnQq@wN`NyDtZbQjDcAx|@iLjNlKxcApJhh@x\\dh@jQbJhRgNkGxQlUjCaPzNdDvG|VfBpJ|OlTmKuLbc@|RkKUtSdLtWdNca@dnA|`@zZpd@hT_R|Ge]rWiQpZr]rSkPcCqYhVvHsKiShNb@rFch@bWfIvFiKf@yR{RbFpKagBcQquArc@wlAjk@sGhElWqSjAuEv_@lDrHfGgKfSzU`Aw`@~Lnh@hEcLwEuWdOIzEag@dGtPoI`QfW`OtDmMyLcMvRaSM`Q~r@rXeByZ|ZzCpSpWoDaWjo@vRvF_d@gQdD_A}Kvk@opBtOqLiWmh@bGqPkP_o@lMoQeSeK`HcG}Au[|Sf@jJpBrJyWfIdVpFyUlPvJ|Cbf@hMcSzMmFxFfIlMsNvjAxk@vOmYlDpQmJhQ|ZxAd@aKhNdPzA}c@uGkMt^}OyLeApMmNyMgBvQiOuII?{RzPpBvPc^rExI~g@}AcMkb@~s@v_@`G}YrEzPfIkK|Mza@tX|TRsn@hIxNbFmL~h@cEoLW`L{^yLs[lqBnj@ft@qe@ddA{F~eC|r@nbBaEfsF`aBdyBna@tlHrgEf_AvTbz@jrDdpCvr@_JzaJfb@zaJzTzvN|UlxCf|@`nFpSrsAnnAjtC|w@ng@hoAla@dg@Qj~Ar]pdAvgHdaBxo@ta@txBznE|}DztAthE~gCdhGxlAdaFlqEf}FfzC`rHltAr}BxqEb_Ht]n_B~XjIbWzoAmH|VbxAvCjm@~zAlxAx{Ab~@d`Atj@zpCfeBrQbwH`nJb}@vgAxzAdlDbzAlm@|mAtvA~aCpoD|gDrfEzsFhkF|TxyC~jDtvAbg@y_@tGvm@r}@bfCdsD|xElnAhFnk@xgA`XbhAtZ|]~aBjeBf_A|Yd`Bt`D~EfeBjp@rt@nw@|{@dwBlWjaDtrEbsJnsKxcA~g@dgAvTp_A~fAdv@pjC`fC}_AzbA{vB~MgcDzh@oV||HqlAnrFqyB`sDahAx|@qOvlBpOng@dEjwBuo@~mBzi@x}E~V~aBzBpd@nqBta@|[`y@fJn`@u_@Cyw@pQ{h@aBoe@zSua@`V~j@N~g@f[eAhUp^b^kHrNtq@llAzg@jOto@|h@dCdVwi@pYiCzGgQgT_h@ie@~BmD}c@_ZgScO|A_Heo@zDuN_Ja[~Rq^{G{SfKqBjXvh@lVzBtYvi@ju@|VdMiEeAa`@fKiDI{VbSwMaFmTjHo^wSmuAzSdEe^_hA[kZlTsSb[nTrS}U~q@aBnMwh@rKaHjHii@zUdCcIg`@tB}U|IC`QnYdJ{PaQ_W|TuFxT}w@rHeIl^zHfI_MsGk^dKTbAue@q[mt@vU_ReFce@rp@r]zX}l@gBgWxHwDiAuOvOcc@wJ{VtGsEwH}\\`MlCwD}XnPgUpv@pj@`Jf^`GcByH{KdR}AbXn`BtNdHhQc^lLv^|QtJfZoWpK|LtOcGkE}RzUuDqBaQbZcFbYx`@nj@rWbFuf@hMiEwSeXdImS`^zi@lP\\hw@sw@tUobAzXvZjd@yKjDxv@~Wr{A~Ap`C{NnRqg@_BszA|aAvSzy@}MrdAkz@~UoKpy@i|@|uAek@p`CzGhV`]nIdZ~^\\lQkNtSYh\\wU|t@xClp@uQ|RqHbg@fRftBh}@zmArCh\\}Vz`Ac]xKfBfy@eV~r@mj@|a@}Uvp@oxAzi@cQfSkI~LmDbm@mQv^iAbr@cw@r_@}VjkB~t@hzAnGrq@g\\rwAyOne@nHtd@jE`iCrGpf@t]j_@ChPyQddAiLbFqMxo@il@t|@wRddA|JfgCbTlc@oU|yA_}AxjB{D`]ky@|Hc[fhAeYrBsy@tr@cHtT`NtWgKvkDvMn^jt@lw@B~PyGbSGrs@i[|u@mBp_BocA~nEfF~u@{NtUvJt_Aey@kBoe@_y@{Ku@saAt_@aV`u@rBn\\uIre@|PvEpBxUtMdGj`@riARj]}WtM}\\`}@wGny@aVxg@sAre@yX`bAqo@kCx@luAaKna@|E`j@}XfnAcCjeAwf@jaD|Bnb@_QfKmJhy@se@vaBcR`\\{h@m[oz@xGkS_b@e_@dDwj@mVma@hgAeO{Q_rAiCmn@naAeTjnAg|@f}@c^vx@gYjOsJnb@_h@~[_g@P{h@dR{gAd~@oTaDqWt^iEdt@lMrRwDj[`Nrr@c@v[mo@`vAvDl~@tSvXwXfTk[jt@wUrNcLmIy[|Uc\\biAdAl\\p\\nhAwz@ddAmd@oGuk@lt@|A`|Ahg@|s@rPjv@cCna@dVvd@|ZnJzF|Sj^nWvk@uQlMnMfPkCoAf_A}Rl`@sUdIc[tb@wo@`SoRgLm`@`Jkb@hpAaXncAkc@v\\hDno@gnAbTkK|QcGd`@fCb^a_@tbAdo@hpByTji@uNd`B}o@dNoa@bk@cB|^agBnrApN`dBdz@xoAaI`a@rSfs@qIbo@m@r_@qb@pdArRdm@h^f[iKfgChTve@j[dMzIhRba@c]hLpg@cKxc@s|@p_BhBxi@brAh|@tLl`@jAxh@iRhbAfXdfAEfbA_[f~@ud@`t@}Vzv@wa@hMkI|a@eCz_@hJ|JaKtx@lKjz@mg@rYaR|a@aPjcA}Zt`@{Kjz@~Tn_CeHb\\rGd\\{oAjxDhFha@bOh\\v~@|G~B|l@~jAznBwS~g@~DnG~TbC|m@|t@nt@wVhw@n|Aba@rXmLvf@vUt{@oJxt@dCxTsQsGgWjKyXhy@k_@t`@sOfz@_Ta@gOtRc{@joDjSx^ry@p_@}NheAwQ`e@|ZfzAJfx@~Zrv@eG~OnBjf@lJjd@hNlHpnAkk@`Kyc@f@{j@|LcJbZpElh@m_Bz^qd@lCa]th@{|@|eAn}@}Blh@`Jht@v[rU{e@~w@bVnhAmXni@jEz^`g@vu@jK~k@vQnHfh@bv@eCz]fm@fZjRoLxLjEtIbXp@`m@xZtn@p_@nD~n@kc@~PYxd@ln@kSzhBbFff@vN`HtXpiAtBvg@jSpd@jMhrA{Th@c]xg@kKnd@q_@zEwZtj@eQkD{BwTaTnN{Nrp@dItm@|[na@iCpfAuPcj@o`AePqQf`@yfAlhAgDza@|El`@pa@~ZpKfh@vb@hd@eGjQxD`t@_rA|vAKpPv^jaAiL|L{\\k^gc@kEySbZkHuPjCeXtf@mL_KeVoW`EuY|fA`Ob}A_MvK}SmCcc@mh@sMlQcBhj@`XjzAyP~_@iKvDsr@iW{]|lAsMrHqOcD_Zqy@}KiA{JnSl@fa@uJbk@oz@oR_Rlb@pAne@xErb@w\\z]~Fv[kLtxBlBpe@htAfgDfPL~PdxB_AdVySfB{RhVmQntAwf@zOmE|j@t`@zUlaAoMhBzo@|i@b]he@vC|_@jq@kNv_@`In_@po@pe@aTdlArGha@qm@zdAeLx{Ai]bhA{Dr}@{TrVs^{AgKhSmNrqAiKrHwJjp@e_@tu@qBrl@~GnTaJd~AjV_]pBp]ePxn@aQpJ`@vY`LpOpk@rCd@ab@hJsOj[dQzX_@vIvPih@dXaTvw@pKpWhe@aAtN`NrOzg@fLv~AwB|p@y[fKsn@wAy[t_@~Al[|f@jL`P~h@s@v^cQtb@|Cvk@oJzi@fE~MuHl}@|FfQzt@tYpZhA}O_uAtvAt~@he@c[x`@}BxvA~N|r@fz@uAzb@sn@r`Bb@nzBnb@nZaSvzAyP|CtKf]cFnc@xNbJpKtv@ma@|_AfTlm@jUnF`R~y@{Axq@j[x^da@vDxZr^LxsAfPuQdJfe@zw@es@leA`pB_XoF}r@`k@wS?}CvMvI~Wp]fAbA~S~_@xQvEp[hMyItn@dd@~NiLti@lYh~@yBls@df@x\\xr@v\\dO~`@vv@~QjIzt@e@dj@nRpv@cZvQlBlOba@~lAbw@~q@C`StPtj@iHlGeTfRnNb_@oGvEbfAmLjm@uf@dx@sSbpAc\\vg@gMtBuO~o@uHhhAygAzvAaf@uP{i@byBsa@dr@pJ~_AaOnhCaKvb@|CjRsPxq@hGni@}Ble@lVdp@|Exq@lfAgKnRnTbRmBxXfvAh^xZe@rPvc@pbAxOjD{AhqBlFlg@hN~UoS`EoDfe@w]xZr@ni@|JrPie@|kApl@`mAwDjbAmb@lb@mOv_Bqs@h\\kh@it@qq@_Myc@bNX{O_O_W{f@a_@{Feh@wt@ea@wf@tIeJeTo[{@qO}{@eWwXkM{eBki@nR_iA||@}Bl~A}PbJga@uB{qBygA}bArc@qy@~KoHjMwQwBoZuToF{Uuc@hEek@}Lc[nJeq@~x@apBxGoZxL}z@kI{HbxAqCtu@r^ddCxRx]lpAbhAd`@~iAk[bFyEbOjF`ZqKcEyKbPjE`F}LpAbExPqG}EVdPkStKpIpGeHdHTfVqHrAhEzOiFuHOnQmK~HdDdGeGnA`EjIqGrHlJ~KiLxFfFtMmItG~@|Q{HrA~Ab[eLlZrFrHoKzDxAzm@mKvLbJ`f@_NsAhDjUiHpInO~C_JzPbJdUo`Bul@wdAiw@k_@nbAmn@@mGsVw^gGwQ`Jtp@~`BbPlvAsZt`@gMQo^ru@jBft@tOjm@ic@nDa}@ltA{SkLwd@lTsIpUyb@vUzEbEiRlVuu@sCyv@hPmaAhu@g^xGcRbg@cYaB}_@b_@y}C|Q_iA_KzCxl@eJ~\\km@vj@Y`pAgPf\\aVlwAws@h}@qj@ef@q_Axl@~PtlAgQdg@nBdMjo@hYhWgRlRhRhRbfAcArp@rUrnAre@pR`_@aDxh@tn@YjWrN|e@_Afc@~[nnA|z@aL|Xzi@du@kKbe@dNzPtVd@b_BpMbvAjJrU`CjaAmRX}MjRwAr_@jTvaAtAhi@kLbfAjTni@_Bb`AdFpUrWcA|gBnlDji@{CrKuQvd@nHfV`o@z^gV|OxYlaAli@dY~AvMsk@`ScFzy@lQjTvb@fMtBaSp}@zU``A~rAhoAhPuBbd@gk@`^~Mxl@qe@hXv{@oX`iAh}@ziCX~OaZbb@kK`n@vJ|]lQfHjN`bAkEtpAee@vYsFjPh@dh@i_@pLqK`tB|a@|N{Kjc@mCh`At\\zKnb@dn@rP}IdHnGjZfs@`Ljy@kNbkAhIv\\}Pfs@oChjAtRd|@s]hg@cKzLo]iK{MdUaXjDet@ciBmx@uSeN``@ek@fd@_MgFiOdSef@nJaRxpAyqA{`@a[bIiZab@cd@z{@mJ{Oet@gReVkk@ab@bBsWv[nAbS}P~MoVlp@Gpa@s\\dOcOhaBna@rqEeMb`AdDdeAgUpu@jNnrAe@rNeFiC_Anu@u^bb@k[mm@sc@vBaHcR~EkO{T_o@cnAgJiVh}@cYvA}MjSLtf@iLjK}e@{@oYbZgVwIwj@dSyN{Uau@gVhAd|@y_@p[i`@hIyv@kFsX`a@gb@aHom@dR}OlYea@yAufAbk@ef@kQwq@lOah@oTmh@la@gAr~@wa@xeArA~^fL|dA{MhOjo@dpAdAt~@{YvP}Sds@jHpg@cD|e@{XqDiX~SoZw@fCdb@uYaMeO|VyLyJcLhbBvPjnA_LlQ~Md|@{e@hGiFxr@~Rrd@aTt@aGjaAwOja@qL[cHbYiStOkBtYkVwUcVjOmjB{Q_T|T_Nnz@qMvP}e@uEmy@|WmXtb@ie@tLqUn`@oc@_Lgm@jg@_[v@qUlp@i]tMgh@gAy_AjpAeh@x@cgAw}Byg@zc@qB{_@yR_QuEcjA_[qJk\\fh@gGvu@dDh~@cOxBoXv}@wNmJk\\zb@qJm@{`@kn@kVjOwuAox@}Lvf@mOoKcFhLwIgOes@lSjVpqAwp@n{A^la@fSwUvO`Ofo@rB`Q_l@|g@rt@zBlTzMhCQb[kGvDhHdCyH|IbI|PuPxZuCdtAxFPmC`K_E_Fr@dTmI|GxJbJuS|NhQx[mJpAiF|`@oZ~Kc`@zbB}e@lVkCjnB_`@zo@Zv\\o}@fLuAfy@pFjU|SfaDaIz}A_ItPnBr`@gl@ziAmKbtBuTb]xy@}J`Iec@qJ}b@d]y_@vHpJoDbp@dO|EvNkx@o@j_@bYt\\yHtf@}Qj@cArRpl@dBtj@zm@~BtZoRtQk^~aB}GwHyTfI@ly@us@xp@kKyDyDnTo`AmOawApa@ag@lxFdTh{AeZzl@iwAxAwhAjl@hTlrAqYrRcIhk@Rr|@xIkCHpc@`\\[vX}U|XtYtRplAkx@`r@gM|bA_UrIaChSnWlwAaOjHeYxaA{dAd~@cQtGqn@u|@qy@rlB{jAmVoJlT|@pt@iNlfAo^kInAzVig@zK`DfiAiYnViAv_@qPfc@z]nxAbe@nu@tFvi@zu@iHfj@rMtg@g[nEwYoFs\\k\\gZsA}MwL]nLwyBjx@}[r`@~d@rOkXzTfC^~VfLvHtS}\\h_@n@wTfs@_NhJz@|lD{n@tPd]~~Azs@ld@wV`sA|B~YjSzUOxo@frBztCdp@bl@~LptAiUxyBnn@hbC_r@vj@zCx\\cQzLRtSwXfDC`n@ua@h_@zNrUeYzn@_{@o`Aco@fx@_FzqCuJxv@iTn@mH`QxJrTaQ~TO|o@ua@|d@sMm^yM_Ek[~Ka@p`@qNhBw[aXsHvOs\\eD_BrN{Mi@`BpMaOt`@{LgCYiLgE~PwJv@v@fZwFkIoOdUmJ_\\cGdReLcOjBhP_HoB}E~YuTjI_FoI_JlSkPh@_Ozc@`BfP{Jp@dAjJeb@dv@ax@cHwjB|_DeOxr@}@xsAfxAhh@kb@tzAgLvgAkiAdh@iKsE{d@n[eh@dnC{J~BaDjc@yv@t^ycA`qAi{@}s@cGoSo@m~AjKmd@uYc^}@se@_Nkg@oIikCy^otAfG}XqSsbCmH_GqSlIgMeg@al@lCiS}l@iSEqDyi@pX_`AvAwg@cSgj@cG_`AaX`Ekd@uNo]nTm|Ass@g~BbyFkcBwDw\\wu@esA}r@yKo]oUgC}FkUyHdCeI`JeAzXhFtBcIlXpCzReMhZh@|Z_yArf@aOtTeo@pgEjlA}Kp|@xJfWsKpPpRzKn_@f]d_@dE`k@~X|ZfLhf@nk@fk@fItw@dNhSdi@dcCbE`d@eF|c@gPpP}Ct[cYpAuX|b@nEvdAln@|hBqDtUtDhlBwOfoAsKn`@x@ryB|DhjBv[~aBoApRtNr_@oOpl@ly@aE`U~Ll_@`_B}Np|@}ZpKqZ{TyxAt`AxTfuAkb@vd@uRrhAhChnChb@vUnjAIaEb[vGfr@{bAfh@_[eCoYpe@wWk`As\\vTyf@eI}c@_^mU{MmVr^}FndAc{@uQUio@}NiJyQpGxFlaCjh@~|ArQtmCoUtwAej@nfA{VpeBa^d^}]laAoZbw@efA|~@mg@liAcdAtKadA_\\}VdzBvVp[rN|hBjUb`@eH~^~Exu@ktAvzBnAtlAoeAdAuFtu@pAlhBtVnPeVbvA{FbbBgp@jzAkB|q@ae@ha@J`d@tPb]{c@`m@mSbp@|n@f|ApMny@qUjPe\\bp@sp@dkBwg@vuCqXfZk]n{@xIvy@`Zh`@yChh@~I~`@|e@nA`Uf_@xZq@nb@dh@z`@eAza@~u@lVxAeFoTpd@ss@ne@koBrk@kv@wImq@fMgW`W`D|Os]vNlCtcAs_@jd@fYhP{W|xAo`ApUyn@lZfEn\\kKpO~X|r@k^vMuGdKoa@hNPdLw^lCe|@oIeEoIcf@jo@{_@lc@o{BoC{k@~DqKhc@uEhEe`@liB}cAfcAxThk@zh@bWzr@hT{InV_n@`p@mCzDsVvbAgnApR`i@`l@bi@`TxbBicAnf@mj@b~@gp@~IyRvZle@fqAfTdIfa@m\\~Ufm@jUpNnFle@qIn^j@nbByOn`@mCbe@bUbtBjXnBnMdy@bSlVpy@x@xXpPdOj_AeFhs@uQpGaVf`AyPrPjYbdAhEzM`[kCvSr}@bd@xQkT|d@fCvVdu@hn@lOr\\hyAvS~u@dj@na@dv@ze@eFz]v|A~e@rlAwG|ZxBlc@~yAneApSh\\tgAl_@bu@rnBsKdkBi_@taAqd@lxC}MlkAfDzn@q{@ts@qX`eAol@bLaIfs@yRjUqSx[hAbd@oM`y@gSu[uQ|ZuUq_@sQjn@eNgBch@llBc{@pOgd@cb@uY`ToCzSwYaJkk@~ZySeOkUhEqQc_@km@fQaHx\\aLySwSwBsOne@ai@~Ps@dRyV|[q_@tR`Htr@_Jnf@qWrc@{XdYeYkHcFrc@_P|ImLsGsOnJxAxu@_VpVoCzWyg@lPaCh^gb@jJk|@~rAySaHePbT_P\\ky@peB{`@lKod@jr@g[~GeYrg@vBnkBh@lQdYlZ~D|d@e{@fcBcsAdq@u[|`Aii@vT_Vo\\oc@t@yVaNgVrZkSeG_`@pWsCrVlGb\\wKdXdPnm@gYn{A~Jry@kQdr@hBbXlJ~`@taA`o@xNn^Vfp@wu@bJaQtt@uNpMc_@cHsi@bZLnlAyOlSyKDaHk[gd@mEeXteAcVlJgCpOvJhj@x_@fs@_ZbfAqTwUqjArYqPxc@tClb@qS`OeOoQck@_@}i@qe@sSqjAtE_Zz[vBdYyRwDcl@sb@{PwK`U_R~@uXn|@yPmWbDqcAoUa@oO|UcCcJnVm|@q[clAyc@jh@sh@c{@Vae@bYsVmCie@wQr^wSbFaJoQxBgMpHx@zOe_AwEa]vIwa@sd@gb@cf@wC~A{XoRqo@y_@nQii@_LaHqx@jXohAlV_JNiWbWkb@mCwWmPwBnGiSef@{mA}lA__AuUikA_c@yo@wJya@{JwIeTj^}FeHom@vbA}c@crCet@x@c^hMqSfZw[aCNyeBy_AysCkj@zH}zBh~BwVp~@{k@|o@yGr`AugA|vAmX`McLyGkAvILvZwfA`cA`Izf@eFp]_\\hJg]|`@aYrDaDjNi@fi@kXnjAfLxp@lLrEhSro@aJl\\lA~cB{DdMyh@tJlBfp@yCxu@jF~]yZbrC`Wp[hdBvu@hhAjBbHbKlJoHrRxRzPnlCfSrk@yGfr@e^{Cod@~Reb@dh@kq@jhC|Npv@k`@j^_Hxg@{QdLd@hz@bJ~SqMzIaFrWaGtUtCbP`{@tc@|@zc@bb@rZvl@djB~zApo@|q@nNnVqEjTlMi[dsAp`BbnBgI``@qc@`WsCh[nLlOoc@loBmQrXyIu@ul@ccAyn@}uCoR`a@oFpo@{p@lRiMd[wWoX_OhIyi@eEah@`W_WdOuWiDoDj^uU`Tag@kB}r@jsCnA~gAxYzoA~Ad`Afc@~c@_Wrh@z\\doA|ZffCbYpEoS`oCcj@qM_gDpkAyIx]qyAhdBgqBqK_k@hkAwa@|T|Ddp@zJjx@c@|n@|c@~O|Zpz@_GrxBpn@z{Bm@`a@cSjc@jLpmCwOj`A{Pfh@k|@n\\gLxUsKrmAmRns@mDxkB{ZpzBcO`Lq[lUwWxnAsOtzCxPb{AcZvqBvE|_AxMlcAiuAdrAdOlkBiO`qA_d@~j@gY~{@oR|nA}QjCgKtfA`PnrAjRr[j`A`c@x`AvfArb@~y@tE`w@wNp\\hAlb@aUz]uUuUscA~Dmf@nf@oSuNqKi`@aDnKuU}K_OfXw\\aKsKyXcNnW_mA|Wye@fp@_x@`h@hBnUoSj[vFhCmB`KwJJdCxKeObNdFzE_FpZ`DhVaOxAjDtMqK|YjA`l@sIx^a|AtkBs`@zNgy@`oAkULej@tDa|@~b@{YsAi\\|Vm_@oP}j@rJ{VkQiPug@aUaOaVgv@qf@aUq`@zXs]zwAou@ySop@rRsHn|BxGra@qf@fx@}MaXyL~[aFuGuP|P{Mc_@wI`c@rOdv@dBrx@xTfb@cBlt@`Ybo@`ZiTrTbr@mN|iA{Tht@oLaY}\\uI_eDl`@lHpUd_@ftCtxBjeAv@ao@hMgGoAvd@~Htn@}R`o@`Kl`BcOhZaw@~W_PgTwGmd@wSgB{Pxr@rC~[eMlu@bGlDJ`m@yQ}@}Fvo@}KlEgKxKmD|r@`{@dAvDzqBaDzVqOtNsFmMy\\lOh@zVaK|HtFt`@yEfJ|FxTlc@lLdBj`@bf@jhAeI|hA`ZxHbfBn`BbL}c@v|@k{AuSmQq_@uvAl]}^`z@eXf_@sh@t@tZ|Vzg@jnAk[vh@fMpViGtUre@lc@|]rMbO~Dr_@z`@dd@zg@_a@rHiUbi@iCoA{n@dh@laAvb@uAhRlO~MkWxoAkTfo@{BiBd~A`m@njDkMbeAk_@taAkg@`~EQlHxt@`Qum@t}AsMtr@Mhi@~h@pS`Jjs@mHls@rFlg@cWly@pM`p@wUhXq`@`Kok@qTgvAclC_}@mr@oh@i`BqYwS_cAqf@}P}uA}`@ec@kh@fFoMdNi|@a\\kJcf@aLvYeYwZkY|DeHmz@aEqa@aLoHof@jGq`@mKwKpPs_@x@sOyRpFi[iG}XisA{v@wa@iGuEvTwKrC_L{MtHmNiQjCWwRsN|KiBcb@gVaRwB|M}K}IkZ_TeJpUwIuI_IfGqDsKtEwGsY_JMaY}R_U_@oSip@`Iao@gr@{U]a@zSyHrAsf@ciAyy@bSqAyVsNhAaFkYaXlFiDrNoHiUe]_@od@~c@iEuRaH|FoPyOePzIaJkKbHkM[aWwYmk@_KgI}EzQkx@yJ{{@de@sFsc@ad@o[im@th@w^fF_`@qiA{XnUuv@il@oRtBuj@`T}\\gz@gON_G`g@_^V{Ue`@}Mu@sClReMn@gJcm@oJfFqVqLgf@nLw\\u|@sKqCuE~RkLca@gMhLcMkJ`Dm]{QiZem@ls@~MhT_IdPmSaI{Cw_@gM_D{Hcl@ob@hMkPsM{TdH}CaMoQmPsT`n@{_@yEc]bTuf@sGw@nSiN`EuV~l@iA|y@sYkI{SlGsOvc@q^sNqDrVmRvQm@`]kNd[y]cCqEnl@qWnG_FrQoc@pHqJ~Pe~AtHoPjSlA|a@kJpLuG{DuGgq@cNcWoSr@oZmc@_Z~w@oCp_@cQN}XdZs_@oEiPvM_I``@oK}ZcAkg@a\\hG_k@~w@gN{b@c_@gOud@`QgT}J_[rm@oQc\\tHym@qx@cTwXtl@al@vXg`@|i@k]uBip@~l@gK`kCsk@bKgT`w@g@tu@|Jpx@wMnf@qTrWzRlbBwb@`e@hD|uAq~@piBoXpLeGvo@yNn_@tHvn@kt@xj@yCzd@kN`P|Cvr@sG~WzC`g@gGbjAsZp^|Gxy@mS`o@kC|l@ia@ph@{YBiSjPu`@__@m`@`LwX~b@iGxk@um@h_@exAkiB{w@uYsj@a{@iM{x@sWuJmSmo@}_@wXafA~Jkv@~|@q^sPoo@rKu]eJ{g@v]}u@ki@gRvZoQzBwt@b`@gIdn@cLvP_XiN_]jOcAtq@gdBniDoTf`Aay@jbAk_@rNsR~z@{bAle@{[~b@sm@{V{\\bNwRwg@kIzGiKr~@{I~Kk`@_Yme@}Awd@tMg\\gDwLpUiy@h]wJpw@cTdLzBzdAuHvi@yKhMpBx`@uHvSwkAjo@eV|j@sd@dAoU{S{m@rQoXee@vNi^}AcVeo@dDg@wQpPkKj@iPaM{@{]r^k_@yZ_DqoAwk@o~@{Ksz@m]iOyKqc@ew@cKaVgl@uTcGzDoeAs\\`@aDmf@oe@kpAoLmDi\\pRge@qs@aj@wOaNuReo@zKu[iV{Dm`@g_@ui@o{@oKwU`N_Kx_@im@|b@ykAhRwOeL[c\\_Pm[qtA__@gn@nl@m[_eAsb@eHez@gzAmb@|D}Ogp@ieAqH{TjXwl@|Aqi@ajAk^oJcZdW_~AbvAyr@`iBy[vtCqx@nmA}l@bb@kz@wKu`C~[{wB{qCm`@sMsaAhYcw@vpAc]lQa]aTal@uvAgb@kc@ahBc[ka@wTmPjHsf@l}@el@~Wi`@dr@ch@tpE}@fnAev@jvD_DdnBmNxh@wu@|^cVb~@oRfPy_@O{i@kz@eXeC}h@zh@_s@tKyf@nzA}~@oHs{@|o@yc@nRehBwCed@bK}rBrfByf@uIufA_aAudAzOw\\wHm]eXc[wl@sUakCyj@gj@o}AklCkiAqTq|@{eB_i@oc@cXeDii@pa@il@|iB{x@bO{|@fd@sWMy`Aww@kfAiTajAcgCyXgFmVxOga@fuAic@jz@_nAb`@}_Af`Amd@heBkv@hfBenAxiFwZjnBybAvlCo`@`bBmf@jz@}s@bQaSpTkOt_@gHdtAoQb_@so@jMqa@f^c\\r`A}`Avt@}wAhcC_dA|~@wWzmA_~@ns@aXzsAqp@pjB_QhgBmr@nxCmcBdjDq_AzjAo]tbA{_@bUch@nw@oNjdAwK|hFiPhfBz@hx@{ZjqAmy@tk@wf@Kku@yi@uhCcmDkrAiWmmA|x@u`BhLaiBdn@ygAiH_j@``@}z@a]iMgc@aIynAis@ug@eKgX_YsgBwo@kkBkF{fAsUs|@iDcm@um@k}AoMsr@qj@_{@y}@coC{{@e~Aac@ia@ie@adAy]gzAc_@om@ubBslAaZaDcm@wm@ys@gUygB}A}r@kv@auBgPgaAia@c|A`dByzAh]k|@{Tqd@e]cvAwOgSit@iJqsAoWyg@_mAqOgdAknA}h@mgAgo@cNib@qd@ue@ow@ue@fGob@|[qKyDsIfuCg`Dhf@mi@tq@y`B_u@odA~j@mgAbQsh@`~Ay_Bw^og@hBujAxa@yvA`fAek@r[{rC`\\a~AaS{t@xBqDrqAmbEfWim@zTyo@jsCidCtdAg\\iUmk@zTsj@z}@wm@aHqK~[}gAieAm_ClFwiEwYmAlc@}bBbiDqvCsDmZtb@_A|i@mStHgf@s`Ae{@yNq\\fv@cfAdq@ad@wDsFeYeOjUwvDc\\_Q~GwUgKax@`h@qtB_gBe`BrgAopNtsJorAaRyxBlRsf@bs@oWgJyGv~BiL?oIcc@SkfB}oAgvB~b@_nCl@mlCkLie@qi@bDtY{`@|b@oKb~@yoHfBy~Ca]oiE{VggB}_A_jEghA{sCehCa~Eog@kuEwbAurEqi@coD{hA{vIiSofBe}@moEqo@ehCcHcRaJrIdFoP}PchBok@iiEegC}eVgpByhNsdC_~Nc^wrE}_C_ePo~AupLux@_bEaM}b@oKsA|G_HsF}pAmbAejPwf@_bGsD{zIcb@}nDm|@myDg]gw@yRzDzMeRlBifDawAckQygBmaOmz@kwE_t@kwDci@edF}v@cwUgg@e|Hgh@wwEm}@ugGefBmoHesBciGadAy_CulEwtIezD_wGo`CcaDmqB}wBs~Ae~AmYfMpHcd@oHij@ub@s{@c[cXoxEqlEy|Cw}ForAiyDcqA{oCuTe_AwdBg~Lay@ekKcHuqD')
            ->setCenter(array(51.79695260930911, 19.52734375000001))
            ->setType('country')
            ->setName('Polska');
        $manager->persist($countryShape);

        $manager->flush($countryShape);
        echo "1 country shape loaded.\n";


        // 2. region shapes
        $regionsJSON = file_get_contents($regionsSrcFile);
        if (!$regionsJSON) {
            throw new \Exception('Region shapes are unavailable.');
        }
        $regionsArray = json_decode($regionsJSON, true);

        foreach ($regionsArray['wojewodztwa']['wojewodztwa'] as $region) {
            preg_match_all('/[\d\.]+/', $region['GeoWojewodztwo']['spat'], $center);

            $regionShape = new GeoShape();
            $regionShape
                ->setShape($region['GeoWojewodztwo']['enspat'])
                ->setCenter($center[0])
                ->setType('region')
                ->setName($region['GeoWojewodztwo']['nazwa'])
                ->setParent($countryShape);

            $regionObject = $regionsRepository->findOneByName(
                mb_strtolower($region['GeoWojewodztwo']['nazwa'], 'UTF-8')
            );
            if ($regionObject) {
                $regionShape->setRegion($regionObject);
                $regionsByImportId[$region['GeoWojewodztwo']['id']] = $regionObject;
            } else {
                echo "Region not found: " . $region['GeoWojewodztwo']['nazwa'] . "\n";
            }

            $manager->persist($regionShape);
            $regionShapes[$region['GeoWojewodztwo']['id']] = $regionShape;
        }

        $manager->flush();
        echo count($regionShapes) . " region shapes loaded.\n";


        // 3. district shapes
        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()->in($districtsSrcFiles)->name('*.json');
        foreach ($finder as $districtFile) {
            $districtArray = json_decode(file_get_contents($districtFile->getRealpath()), true);
            $currentRegionImportId = basename($districtFile->getRealpath(), '.json'); // file name == region id
            $currentRegion = $regionsByImportId[$currentRegionImportId];

            foreach ($districtArray['powiaty']['powiaty'] as $district) {
                preg_match_all('/[\d\.]+/', $district['GeoPowiat']['spat0'], $center);

                $districtShape = new GeoShape();
                $districtShape
                    ->setShape($district['GeoPowiat']['en_spat0'])
                    ->setCenter($center[0])
                    ->setType('district')
                    ->setName($district['GeoPowiat']['nazwa'])
                    ->setParent($regionShapes[$currentRegionImportId]);

                $districtObject = $districtsRepository->findOneBy(array(
                    'name' => $district['GeoPowiat']['nazwa'],
                    'region' => $currentRegion
                ));
                if ($districtObject) {
                    $districtShape->setDistrict($districtObject);
                    $districtsByImportId[$district['GeoPowiat']['id']] = $districtObject;
                } else {
                    echo "District not found: " . $district['GeoPowiat']['nazwa'] . ", region: " . $currentRegion->getName() . "\n";
                }

                $manager->persist($districtShape);
                $districtShapes[$district['GeoPowiat']['id']] = $districtShape;
            }
        }

        $manager->flush();
        echo count($districtShapes) . " district shapes loaded.\n";


        // 4. communes shapes
        $communeCount = 0;
        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()->in($communesSrcFiles)->name('*.json');
        foreach ($finder as $communeFile) {
            $communeArray = json_decode(file_get_contents($communeFile->getRealpath()), true);
            $commune = $communeArray['object'];
            $currentDistrict = $districtsByImportId[$commune['data']['powiat_id']];

            if ($commune['data']['nazwa'] == 'Słupia (Jędrzejowska)') { // first exception
                $commune['data']['nazwa'] = 'Słupia';
            }

            if (is_array($commune['layers']['enspat']['ADD'])) { // second exception
                $commune['layers']['enspat']['ADD'] = $commune['layers']['enspat']['ADD'][0];
            }

//            preg_match_all('/[\d\.]+/', $commune['GeoGmina']['spat0'], $center); // no central point in this data set
            $communeShape = new GeoShape();
            $communeShape
                ->setShape($commune['layers']['enspat']['ADD'])
                ->setType('commune')
                ->setName($commune['data']['nazwa'])
                ->setParent($districtShapes[$commune['data']['powiat_id']]);

            $communeObject = $communesRepository->findOneBy(array(
                'name' => $commune['data']['nazwa'],
                'terytId' => $commune['data']['teryt']
            ));
            if ($communeObject) {
                $communeShape->setCommune($communeObject);
            } else {
                echo "File: " . $communeFile->getRealpath();
                echo " Commune not found: " . $commune['data']['nazwa'] . ", district: " . $currentDistrict->getName() . ", region: " . $currentDistrict->getRegion()->getName() . "\n";
//                var_dump($commune);
            }

            $manager->persist($communeShape);
            $communeCount++;
        }

        $manager->flush();
        echo $communeCount . " commune shapes loaded.\n";
    }


    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}