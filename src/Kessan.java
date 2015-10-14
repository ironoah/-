class Kessan {
	
	Kessan() {
		// コンストラクタ
	}
	
	public void 収益・費用の各勘定残高を損益勘定に振り替える() {
	}
	
	public void 当期純利益を資本金勘定に振り替える() {
	}
	
	public boolean 各勘定を締め切る() {
		if (!収益と費用の各勘定の締め切り()) {
			return false;
		}
		
		資産・負債・純資産の各勘定の締め切り();
		return true;
	}
	private boolean 収益と費用の各勘定の締め切り() {
		if (売上.借方.損益 != 売上.貸方.現金 +  売上.貸方.売掛金) {
			return false;
		}
		if (損益.借方.仕入 + 損益.借方.資本金 != 損益.貸方.売上) {
			return false;
		}
		if (仕入.借方.現金 + 仕入.借方.買掛金 != 仕入.貸方.損益) {
			return false;
		}
		return true;
	}
	private void 資産・負債・純資産の各勘定の締め切り() {
		現金.次期繰越   =  現金.借方合計   -  現金.貸方合計;
		売掛金.次期繰越 =  売掛金.借方合計 -  売掛金.貸方合計;
		
		買掛金.次期繰越 =  買掛金.貸方合計 -  買掛金.借方合計;
		資本金.次期繰越 =  資本金.貸方合計 -  資本金.借方合計;
	}
	
	public void 繰越試算表を作成する() {
		System.out.println("現金.次期繰越   =  " + 現金.次期繰越  );
		System.out.println("売掛金.次期繰越 =  " + 売掛金.次期繰越);
		System.out.println("買掛金.次期繰越 =  " + 買掛金.次期繰越);
		System.out.println("資本金.次期繰越 =  " + 資本金.次期繰越);
	}
	
	// 本決算だけに特殊なのは引当金計算、税金計算、在庫評価、減損など
}
